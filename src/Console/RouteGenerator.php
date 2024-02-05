<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Filesystem\Filesystem;

trait RouteGenerator
{ 
  
    public function processRouteCreation($name,$namespace = null,$route_name)
    {
        if($namespace){
            (new Filesystem)->append(base_path('routes/web.php'),"\nRoute::resource('$route_name',App\\Http\\Controllers\\$namespace\\{$name}Controller::class);");
        }else{
            (new Filesystem)->append(base_path('routes/web.php'),"\nRoute::resource('$route_name',App\\Http\\Controllers\\{$name}Controller::class);");
        }
         
        $this->output->success("Route Resource for $name Generated Successfully \n Check in web.php");

    }
}