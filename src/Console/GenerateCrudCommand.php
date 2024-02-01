<?php

namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;


class GenerateCrudCommand extends Command  implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate {param}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
            $processCount = 2;
            $bar = $this->output->createProgressBar($processCount); 
            $bar->start();
 
            $param = $this->argument('param');
            $exploded = explode("/", $param);
            $name = "";
            $namespace = "";
            if (count($exploded) > 1) {
                $namespace = $this->toUpperCase($exploded[0]);
                $name =  $this->toUpperCase($exploded[1]);
                Artisan::call("make:model {$this->getNameSingular($name)} -m");

            } else {
                $name =  $this->toUpperCase($exploded[0]);
                Artisan::call("make:model {$this->getNameSingular($param)} -m");

            }

            $this->processRouteCreation($name,$namespace);
            $this->processControllerCreation($name, $namespace);
            $this->processReactComponentCreation($param,$namespace);
            $bar->finish();
            return $this->info("\nYou have successfully generated {$name} CRUD"); 
    }

    public function getNameSingular($name){
        return Str::singular($name);
    }

    public function processReactComponentCreation($param,$namespace){
        
        $baseComponentsDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Pages/BaseCrud';
        
        (new FileSystem())->copyDirectory($baseComponentsDirectory,resource_path("js/Pages/$param"));
        
        $listComponent = resource_path("js/Pages/{$this->toUpperCase($param)}/List.jsx");
        $listContent = file_get_contents($listComponent); 

        $listComponent = fopen($listComponent, "w");
        
        $targetString = "ModelName";
        $newContent = str_replace($targetString, $param, $listContent); //Change the controller name to {$param}Controller

        fwrite($listComponent, $newContent);

    }
    

    public function toUpperCase($string)
    {
        return Str::ucfirst($string);
    }

    public function processControllerCreation($name, $namespace)
    {
        $baseControllerPath = __DIR__ . '../../stubs/BaseController.php';

        $baseControllerContent = file_get_contents($baseControllerPath);

        $controllerName = "{$name}Controller";

        //Create the actual controller
        Artisan::call("make:controller {$namespace}/{$name}Controller");

        if ($namespace) {
            $this->processControllerWithNameSpace($namespace, $controllerName, $baseControllerContent);
        } else {
            $this->processControllerWithoutNameSpace($controllerName, $baseControllerContent);
        }

        return true;
    }


    public function processControllerWithoutNameSpace($controllerName, $baseControllerContent)
    {

        $destinationControllerPath = app_path("/Http/Controllers/{$controllerName}.php");
 
        $destinationController = fopen($destinationControllerPath, "w");

        $newContent = str_replace('BaseController', $controllerName, $baseControllerContent); //Change the controller name to {$param}Controller

        fwrite($destinationController, $newContent);

        fclose($destinationController); 

    }

    public function processControllerWithNameSpace($namespace, $controllerName, $baseControllerContent)
    {
        $createdControllerPath = app_path("/Http/Controllers/$namespace/{$controllerName}.php");

        $initializedFile = fopen($createdControllerPath, "w") or die;

        $newContent = str_replace('BaseController', $controllerName, $baseControllerContent); //Change the controller name to {$param}Controller

        $updatedNameSpaceContent = str_replace('namespace App\Http\Controllers', "namespace App\\Http\\Controllers\\{$namespace};", $newContent); //Change the namespace of the new content

        fwrite($initializedFile, $updatedNameSpaceContent);

        fclose($initializedFile); 

 
    }

    public function processRouteCreation($name,$namespace = null)
    {
        if($namespace){
            (new Filesystem)->append(base_path('routes/web.php'),"\nRoute::resource('{$this->toLower($name)}',App\\Http\\Controllers\\$namespace\\{$name}Controller::class);");
        }else{
            (new Filesystem)->append(base_path('routes/web.php'),"\nRoute::resource('{$this->toLower($name)}',App\\Http\\Controllers\\{$name}Controller::class);");

        }
    }

    public function toLower($name){
        return Str::lower($name);
    }


}
