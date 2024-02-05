<?php 
namespace App\Http\Controllers;

use Markgersaliaph\LaravelCrudGenerate\Http\Controllers\CrudController;

class BaseControllerWithNamespace extends CrudController
{
    protected $main_page_route_name = 'model.index';

    protected $inertiaMainPage = 'Model/Namespace/List'; //name of react path to display
    protected $inertiaFormPage = 'Model/Namespace/Form'; 
}
  