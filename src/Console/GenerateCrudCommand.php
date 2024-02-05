<?php

namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str; 

class GenerateCrudCommand extends Command  implements PromptsForMissingInput
{
    use ControllerGenerator,RouteGenerator,ComponentGenerator,ModelGenerator,MenuCreator;
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
                $modelName = $name; 
            } else {
                $name =  $this->toUpperCase($exploded[0]);
                $modelName = $param;
            }


            
            $this->output->title("Writing In Menus");
            $this->processMenuCreation($param,$namespace); 

    


        
            $this->output->title("Generating Model and Migrations");
            $this->processModelCreation($modelName); 
            
            $this->output->title("Generating Routes");
            $this->processRouteCreation($name,$namespace);

            
            $this->output->title("Generating Controller");
            $this->processControllerCreation($name, $namespace);

            
            $this->output->title("Generating React Components");
            $this->processReactComponentCreation($param,$namespace); 


            $this->info("\nYou have successfully generated {$name} CRUD \n");
            
            $this->output->info("Make sure to run php artisan migrate, and add the fields in the fillable on App\\Models\\$name.php");
    }

    public function getNameSingular($name){
        return Str::singular($name);
    }

    public function toUpperCase($string)
    {
        return Str::ucfirst($string);
    }

    public function toLower($name){
        return Str::lower($name);
    }


}
