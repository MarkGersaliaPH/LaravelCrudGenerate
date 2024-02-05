<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

trait ModelGenerator
{

    public function processModelCreation($name){
        Artisan::call("make:model {$this->getNameSingular($name)} -m");

        $this->output->success("Model and Migration Generated Successfully ");
    }

}