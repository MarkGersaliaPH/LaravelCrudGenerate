<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Filesystem\Filesystem;

trait ComponentGenerator
{

    public function processReactComponentCreation($name,$namespace){
         
        $baseComponentsDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Pages/BaseCrud';
        $resource_path = resource_path("js/Pages/$name/");
        if($namespace){
            $resource_path = resource_path("js/Pages/$namespace/$name/"); 
        }

        (new FileSystem())->copyDirectory($baseComponentsDirectory,$resource_path);

        $files = (new FileSystem())->files($resource_path);
 
        
        $this->addTheModelNameToTheFile($name,$resource_path,'list');
        $this->addTheModelNameToTheFile($name,$resource_path,'form');

        $this->output->success("\nComponents Generated ".implode("\n",$files));

    }

    public function addTheModelNameToTheFile($name,$resource_path,$type){
        $path = $type == "list" ? "$resource_path/List.jsx" : "$resource_path/Form.jsx";
 
        $originalContent = file_get_contents($path); 
        $initializedFile = fopen($path, "w"); 

        $targetString = "PageTitle";
        $newContent = str_replace($targetString, $name, $originalContent); //This will change all the Page Title "PageTitle" to "$name"

        $targetString = "model";
        $newContent = str_replace($targetString, $this->toLower($name), $newContent); //this will change the baseUrl="model" to baseUrl="$name"

        fwrite($initializedFile, $newContent);
    }
 
}