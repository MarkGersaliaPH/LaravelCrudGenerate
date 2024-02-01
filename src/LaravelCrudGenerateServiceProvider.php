<?php

namespace Markgersaliaph\LaravelCrudGenerate;
 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Markgersaliaph\LaravelCrudGenerate\Console\GenerateCrudCommand;
use Markgersaliaph\LaravelCrudGenerate\Console\CrudInstallCommand;

class LaravelCrudGenerateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        // Route::prefix('crud-generator')->as('crud-generator.')->group(function(){
        //     $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        // });    if ($this->app->runningInConsole()) {
        $this->commands([
            GenerateCrudCommand::class, 
            CrudInstallCommand::class, 
        ]); 

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');


    }
}
