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
    protected $signature = 'crud:generate {name}';

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
         
        
            $name = $this->argument('name');
            $has_namespace = $this->choice('Do have namespace?',["yes","no"],1);
            $namespace = null;
            $route_name = $this->toLower($name);
  
            if($has_namespace == "yes"){
                while (empty($namespace)) {
                    $namespace = $this->ask('Enter your namespace:');
        
                    if (empty($namespace)) {
                        $this->error('Name cannot be empty. Please try again.');
                    }
                }

            } 
 
            $is_custom_route_name = $this->choice("Do you want to use this  '{$route_name}' route name?",["yes","no"],0);
            

            if($is_custom_route_name == "no"){
                $route_name = $this->ask('Enter route name');
            }
            

             
            
            // $this->output->title("Writing In Menus");
            // $this->processMenuCreation($param,$namespace); 
            
            $name = $this->toUpperCase($name);
            $namespace = $this->toUpperCase($namespace);
     
            $this->output->title("Generating Model and Migrations");
            $this->processModelCreation($name); 
            
            $this->output->title("Generating Routes");
            $this->processRouteCreation($name,$namespace,$route_name);

            
            $this->output->title("Generating Controller");
            $this->processControllerCreation($name, $namespace,$route_name);

            
            $this->output->title("Generating React Components");
            $this->processReactComponentCreation($name,$namespace,$route_name); 


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
