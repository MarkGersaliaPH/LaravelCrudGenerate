<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Support\Facades\Artisan;

trait ControllerGenerator
{ 
 
    public function processControllerCreation($name, $namespace)
    {
        $baseControllerPath = __DIR__ . '../../stubs/BaseController.php';

        $baseControllerContent = file_get_contents($baseControllerPath);

        $controllerName = "{$name}Controller";

        //Create the actual controller
        Artisan::call("make:controller {$namespace}/{$name}Controller");

        if ($namespace) {
            $this->processControllerWithNameSpace($namespace, $controllerName, $baseControllerContent,$name);
        } else {
            $this->processControllerWithoutNameSpace($controllerName, $baseControllerContent,$name);
        }
        

        $this->output->success("Controller Generated Successfully \n".app_path("/Http/Controllers/{$controllerName}.php"));
    }


    public function processControllerWithoutNameSpace($controllerName, $baseControllerContent,$name)
    {

        $destinationControllerPath = app_path("/Http/Controllers/{$controllerName}.php");
 
        $destinationController = fopen($destinationControllerPath, "w");

        $newContent = str_replace('BaseController', $controllerName, $baseControllerContent); //Change the controller name to {$param}Controller
   
        $newContent = str_replace('model.index',$this->toLower($name).".index", $newContent); //this is to change the main_route="model.index" to "name.index";

        fwrite($destinationController, $newContent);

        fclose($destinationController); 

    }

    public function processControllerWithNameSpace($namespace, $controllerName, $baseControllerContent,$name)
    {
        $createdControllerPath = app_path("/Http/Controllers/$namespace/{$controllerName}.php");

        $initializedFile = fopen($createdControllerPath, "w") or die;

        $newContent = str_replace('BaseController', $controllerName, $baseControllerContent); //Change the controller name to {$param}Controller

        $newContent = str_replace('namespace App\Http\Controllers', "namespace App\\Http\\Controllers\\{$namespace};", $newContent); //Change the namespace of the new content
      
        $newContent = str_replace('model.index',$this->toLower($name), $newContent); //this is to change the main_route="model.index" to "name.index";

        fwrite($initializedFile, $newContent);



       
        $updatedNameSpaceContent = str_replace('namespace App\Http\Controllers', "namespace App\\Http\\Controllers\\{$namespace};", $newContent); //Change the namespace of the new content

        //add main route name

        fclose($initializedFile);  
 
    }


}