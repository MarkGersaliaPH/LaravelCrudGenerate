<?php 
namespace App\Http\Controllers;

use Markgersaliaph\LaravelCrudGenerate\Http\Controllers\CrudController;

class BaseController extends CrudController
{
    protected $main_page_route_name = 'model.index';
}
  