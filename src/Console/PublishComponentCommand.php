<?php

namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class PublishComponentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:publish-components';

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
        // Copy package component to root
        
        $baseComponentsDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Components';
       
        $componentDestinationDirectory = resource_path("js/Components/"); 
  
        $this->copyFileWithProgressBar($baseComponentsDirectory,$componentDestinationDirectory,"Components");
 

        $this->info("\n\nComponents Published");
    }

    public function copyFileWithProgressBar($source,$destination,$type){

       
        $files = (new Filesystem())->allFiles($source);
 

        foreach ($files as $file) { 
            $destinationPath = $destination .  basename($file->getRealPath()); //Destination path with file name
 
            // Copy the file
            (new Filesystem())->copy($file->getRealPath(), $destinationPath);

            $this->info("\nPublished {$file->getRealPath()} to $destinationPath");



        }
 
    }
}
