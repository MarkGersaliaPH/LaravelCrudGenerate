<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Filesystem\Filesystem;

trait ComponentGenerator
{

    public function processReactComponentCreation($name,$namespace,$route_name){
         
        
        if(config('laravel-crud-generate.plain_components')){
            $baseComponentsDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Pages/PlainBaseCrud';
        }else{
            $baseComponentsDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Pages/BaseCrud';
        }
        
        $resource_path = resource_path("js/Pages/$name/");
        if($namespace){
            $resource_path = resource_path("js/Pages/$namespace/$name/"); 
        }

        (new FileSystem())->copyDirectory($baseComponentsDirectory,$resource_path);

        $files = (new FileSystem())->files($resource_path);
 
        
        $this->addTheModelNameToTheFile($name,$resource_path,$route_name,'list');
        $this->addTheModelNameToTheFile($name,$resource_path,$route_name,'form');

        $this->output->success("Components Generated \n".implode("\n",$files));

    }

    public function addTheModelNameToTheFile($name,$resource_path,$route_name,$type){
        $path = $type == "list" ? "$resource_path/List.jsx" : "$resource_path/Form.jsx";
 
        $originalContent = file_get_contents($path); 
        $initializedFile = fopen($path, "w"); 

        $targetString = "PageTitle";
        $newContent = str_replace($targetString, $name, $originalContent); //This will change all the Page Title "PageTitle" to "$name"

        $targetString = "model";
        $newContent = str_replace($targetString, $route_name, $newContent); //this will change the baseUrl="model" to baseUrl="$name"

        fwrite($initializedFile, $newContent);
    }
 
}