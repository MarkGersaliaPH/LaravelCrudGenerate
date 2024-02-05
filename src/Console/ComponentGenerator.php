<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Filesystem\Filesystem;

trait ComponentGenerator
{

    public function processReactComponentCreation($name,$namespace){
         
        $baseComponentsDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Pages/BaseCrud';
        
        (new FileSystem())->copyDirectory($baseComponentsDirectory,resource_path("js/Pages/$name"));
        
        $files = (new FileSystem())->files(resource_path("js/Pages/$name"));
        
        $this->addTheModelNameToTheFile($name,'list');
        $this->addTheModelNameToTheFile($name,'form');

        $this->output->success("Components Generated Successfully".implode("\n",$files));

    }

    public function addTheModelNameToTheFile($name,$type){
        $path = $type == "list" ? resource_path("js/Pages/{$this->toUpperCase($name)}/List.jsx") : resource_path("js/Pages/{$this->toUpperCase($name)}/Form.jsx");
         
        $originalContent = file_get_contents($path); 
        $initializedFile = fopen($path, "w"); 

        $targetString = "PageTitle";
        $newContent = str_replace($targetString, $this->toUpperCase($name), $originalContent); //This will change all the Page Title "PageTitle" to "$name"

        $targetString = "model";
        $newContent = str_replace($targetString, $this->toLower($name), $newContent); //this will change the baseUrl="model" to baseUrl="$name"

        fwrite($initializedFile, $newContent);
    }
 
}