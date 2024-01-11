<?php

namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crud {model}';

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
        //
        $model = $this->argument('model');
 
         Artisan::call("make:model {$model} -m");
         Artisan::call("make:controller {$model}Controller -r");
         $this->info("You Successfully Generated a CRUD for {$model}");

        return $this->info("You have successfully generated {$model} CRUD");
    }
}
