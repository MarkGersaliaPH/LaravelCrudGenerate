<?php

namespace Markgersaliaph\LaravelCrudGenerate;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Markgersaliaph\LaravelCrudGenerate\Console\GenerateCrudCommand;
use Markgersaliaph\LaravelCrudGenerate\Console\PublishComponentCommand;

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
        ]);



        $this->publishes([
            __DIR__ . '../../config/laravel-crud-generate.php' => config_path('laravel-crud-generate.php'),

            __DIR__ . './stubs/resources/inertia-react/js/Components' => resource_path('js/Components'),
        ], 'public');


        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    // php artisan vendor:publish --tag=public --provider=" Markgersaliaph\LaravelCrudGenerate\LaravelCrudGenerateServiceProvider"

}
