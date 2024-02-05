<?php

namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class CrudInstallCommand extends Command
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
        $baseLayoutDirectory = __DIR__.'../../stubs/resources/inertia-react/js/Layouts';

        $componentDestinationDirectory = resource_path("js/Components/");
        $layoutDestinationDirectory = resource_path("js/Layouts/");
  
        $this->copyFileWithProgressBar($baseComponentsDirectory,$componentDestinationDirectory,"Components");

        
        $this->copyFileWithProgressBar($baseLayoutDirectory,$layoutDestinationDirectory,"Layouts");

        $this->info("\n\nComponents Installed");
    }

    public function copyFileWithProgressBar($source,$destination,$type){

        $files = (new Filesystem())->allFiles($source);
        $this->output->title("Publishing resources/js/$type");
 

        foreach ($files as $file) {
            $relativePath = str_replace($source, '', $file->getRealPath());
            $destinationPath = $destination;
            (new Filesystem())->copy($relativePath,$file);
            $this->info("published: " . $file);
            
        }

        
        // $progressBar->finish();
        // $this->output->text("\n$type published: " . implode("\n", $files));
    }
}
