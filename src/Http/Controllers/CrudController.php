<?php

namespace Markgersaliaph\LaravelCrudGenerate\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request; 
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Markgersaliaph\LaravelCrudGenerate\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\This; 
class CrudController extends Controller
{
    protected $perPage = 15, $page = 1, $model, $modelName, $filter, $errorMessages = [];
    protected $renderByInertia = true;
    protected $inertiaMainPage; //name of react path to display
    protected $inertiaFormPage;
    protected $inertiaShowPage;
    protected $main_page_route_name;

    public function __construct()
    {
        $this->perPage = \request('ipp', $this->perPage);
        $this->page = \request('page', $this->page);
    }

    protected function getInertiaMainPage()
    {
        return $this->inertiaMainPage ?: $this->getControllerName() . "/List";
    }

    protected function getFormPage()
    {
        return $this->inertiaFormPage ?: $this->getControllerName() . "/Form";
    }

    protected function getShowPage()
    {
        return $this->inertiaShowPage ?: $this->getControllerName() . "/Form";
    }

    protected function model()
    {
        if (!$this->model) {
            if (!$this->modelName) {
                $this->modelName = $this->getControllerNameInSingular();
            }
            $model = "App\Models\\$this->modelName";
            $this->model = new $model();
        }

        return $this->model;
    }

    public function index(Request $request)
    { 
        try {
            $data = [
                'items' => $this->getData()
            ];

            if ($this->renderByInertia) {
                return Inertia::render($this->getInertiaMainPage(), $data);
            }

            return $this->buildJson($data);

        } catch (\Exception $e) {
            return $this->buildErrorFromException($e);
        }
    }

    protected function getData()
    {

        return $this->model()
            // ->search($this->searchFields(), \request()->get('q'))
            // ->filter(\request()->get('filters',[]))
            ->when($this->defaultWhere(), function ($q) {
                $q->where($this->defaultWhere());
            })
            ->when(\request()->get('orderBy'), function ($q) {
                $q->orderByRaw(\request()->get('orderBy'));
            })
            ->when($this->eagerLoad(), function ($q) {
                $q->with($this->eagerLoad());
            })
            ->paginate($this->getPerPage())->withQueryString();
    }

    public function getPerPage()
    {
        return $this->perPage;
    }


    public function show($resource)
    {
        $resource = $this->processResource($resource);

        if ($this->renderByInertia) {
            return Inertia::render($this->getShowPage(), ['item' => $resource]);
        }

        return $this->buildJson(['item' => $resource]);
    }

    public function create()
    {
        if ($this->renderByInertia) {
            return Inertia::render($this->getFormPage(), ['item' => $this->model()]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->createRules(), $this->getErrorMessages(), $this->getValidationAttributes());
 
        try {
            \DB::beginTransaction();
            $resource = $this->model();
            $resource->fill($request->all());
            $resource = $this->beforeCreate($resource);
            $resource->save();
            $resource = $this->afterCreate($resource);
            \DB::commit();
            return $this->storeResponse(['item' => $resource, 'msg' => $this->modelName . ' was successfully created.']);
        } catch (\Exception $e) { 
            \DB::rollback();
            return $this->exceptionResponseBackToForm($e);
        }
    }

    public function edit($resource)
    {
        $resource = $this->processResource($resource);

        if ($this->renderByInertia) {
            return Inertia::render($this->getFormPage(), ['item' => $resource]);
        }

        return $this->buildJson(['item' => $resource]);
    }

    public function update(Request $request, $resource)
    {
        $this->validate($request, $this->updateRules(), $this->getErrorMessages(), $this->getValidationAttributes());

        try {
            \DB::beginTransaction();
            $resource = $this->processResource($resource);
            $resource->fill($request->all());
            $resource = $this->beforeUpdate($resource);
            $resource->save();
            $resource = $this->afterUpdate($resource);
            \DB::commit();
            return $this->updateResponse(['item' => $resource, 'msg' => $this->modelName . ' was successfully updated.']);
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->exceptionResponseBackToForm($e);
        }
    }

    public function destroy($resource)
    {
        try {
            \DB::beginTransaction();
            $resource = $this->processResource($resource);
            $resource = $this->beforeDestroy($resource);
            $resource->delete();
            $resource = $this->afterDestroy($resource);
            \DB::commit();
            return $this->deleteResponse(['item' => $resource, 'msg' => $this->modelName . ' was successfully deleted.']);
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->exceptionResponse($e);
        }
    }

    protected function createRules()
    {
        return $this->getRules();
    }

    protected function updateRules()
    {
        return $this->getRules();
    }

    protected function getRules()
    {
        return [];
    }

    protected function getErrorMessages()
    {
        return $this->errorMessages;
    }

    protected function getValidationAttributes()
    {
        return [];
    }

    protected function processResource($resource)
    {
        if (is_string($resource)) {
            $resource = $this->model() ->when($this->eagerLoad(), function ($q) {
                $q->with($this->eagerLoad());
            })->find($resource);
            if(!$resource) {
                abort(404);
            }
        }
        return $resource;
    }

    protected function storeResponse($data)
    {
        return $this->response($data);
    }

    protected function updateResponse($data)
    {
        return $this->response($data);
    }

    protected function deleteResponse($data)
    {
        return $this->response($data);
    }

    protected function exceptionResponseBackToForm($exception, $status = 200, $header = [], $options = 0)
    {
        Log::error($exception->getMessage());
        if ($this->renderByInertia) {

            $msg = config('app.env') === 'prod' ? 'Server Error' : $exception->getMessage();
            return \redirect()->back()->with(['error_message' => $msg]);
        }

        return $this->buildErrorFromException($exception, $status = 200, $header = [], $options = 0);
    }

    protected function exceptionResponse($exception, $status = 200, $header = [], $options = 0)
    {
        if ($this->renderByInertia) {
            Log::error($exception->getMessage());
            $msg = config('app.env') === 'prod' ? 'Server Error' : $exception->getMessage();
            return to_route($this->main_page_route_name)->with(['error_message' => $msg]);
        }

        return $this->buildErrorFromException($exception, $status = 200, $header = [], $options = 0);
    }

    protected function response($data)
    {
        if ($this->renderByInertia) {
            return to_route($this->main_page_route_name)->with($data);
        }

        return $this->buildJson($data);
    }

    protected function beforeCreate($r)
    {
        return $r;
    }

    protected function beforeUpdate($r)
    {
        return $r;
    }

    protected function beforeDestroy($r)
    {
        return $r;
    }

    protected function afterCreate($r)
    {
        return $r;
    }

    protected function afterUpdate($r)
    {
        return $r;
    }

    protected function afterDestroy($r)
    {
        return $r;
    }

    protected function searchFields()
    {
        return ['name'];
    }

    protected function defaultWhere()
    {
        //you can put closure or array of value
        return null;
    }

    protected function eagerLoad()
    {
        return null;
    }

    protected function getControllerNameInSingular(): string
    {
        return Str::singular($this->getControllerName());
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return str_replace('Controller', '', class_basename($this));
    }
}
