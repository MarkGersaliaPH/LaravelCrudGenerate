<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Support\Facades\Artisan;

trait ControllerGenerator
{ 
 
    public function processControllerCreation($name, $namespace,$route_name)
    {
        $controllerName = "{$name}Controller";

        //Create the actual controller
        Artisan::call("make:controller {$namespace}/{$name}Controller");

        if ($namespace) {
            $baseControllerPath = __DIR__ . '../../stubs/BaseControllerWithNamespace.php';

            $baseControllerContent = file_get_contents($baseControllerPath);

            $this->processControllerWithNameSpace($namespace, $controllerName, $baseControllerContent,$name,$route_name);
        } else {

            $baseControllerPath = __DIR__ . '../../stubs/BaseController.php';

            $baseControllerContent = file_get_contents($baseControllerPath);

            $this->processControllerWithoutNameSpace($controllerName, $baseControllerContent,$name,$route_name);
        }
        
        $this->output->success("Controller Generated Successfully \n".app_path("/Http/Controllers/{$controllerName}.php"));
    }


    public function processControllerWithoutNameSpace($controllerName, $baseControllerContent,$name,$route_name)
    {

        $destinationControllerPath = app_path("/Http/Controllers/{$controllerName}.php");
 
        $destinationController = fopen($destinationControllerPath, "w");

        $newContent = str_replace('BaseController', $controllerName, $baseControllerContent); //Change the controller name to {$param}Controller
   
        $newContent = str_replace('model.index',$route_name.".index", $newContent); //this is to change the main_route="model.index" to "name.index";

        fwrite($destinationController, $newContent);

        fclose($destinationController); 

    }

    public function processControllerWithNameSpace($namespace, $controllerName, $baseControllerContent,$name,$route_name)
    {
        $createdControllerPath = app_path("/Http/Controllers/$namespace/{$controllerName}.php");

        $initializedFile = fopen($createdControllerPath, "w") or die;

        $newContent = str_replace('BaseControllerWithNamespace', $controllerName, $baseControllerContent); //Change the controller name to {$param}Controller

        $newContent = str_replace('namespace App\Http\Controllers', "namespace App\\Http\\Controllers\\{$namespace};", $newContent); //Change the namespace of the new content
      
        $newContent = str_replace('model.index',$route_name.".index", $newContent); //this is to change the main_route="model.index" to "name.index";
       
        $newContent = str_replace('Model/Namespace/',"$namespace/$name/", $newContent); //this is to change the react pages like $inertiaMainPage = 'Model/Namespace/List' to $inertiaMainPage = 'Namespace/Name/List' ";

        fwrite($initializedFile, $newContent); 

        //add main route name

        fclose($initializedFile);  
 
    }


}