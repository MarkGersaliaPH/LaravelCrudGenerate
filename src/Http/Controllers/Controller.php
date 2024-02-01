<?php

namespace Markgersaliaph\LaravelCrudGenerate\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Used to build json output
     * @param $data
     * @param int $status
     * @param array $header
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function buildJson($data, $status = 200, $header = [], $options = 0)
    {
        $default_data = ['success' => true, 'msg' => '', 'errors' => []];

        return response()->json(array_merge($default_data, $data), $status, $header, $options);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function buildErrorJson($data, $status = 200, $header = [], $options = 0)
    {
        $error_data = ['success' => false];
        if (is_string($data)) {
            $error_data['msg'] = $data;
        } else {
            $error_data = array_merge($error_data, $data);
        }
        return $this->buildJson($error_data, $status, $header, $options);
    }

    public function buildErrorFromException($exception, $status = 200, $header = [], $options = 0)
    {
        if($this->renderByInertia) {
            throw $exception;
        }

        Log::error($exception->getTraceAsString());
        $msg = config('app.env') === 'prod' ? 'Server Error' : $exception->getMessage();
        return $this->buildErrorJson(['msg' => $msg], $status, $header, $options);
    }

    public function buildValidationErrorJson($errors, $status = 200, $header = [], $options = 0)
    {
        return $this->buildErrorJson(['errors' => $errors, 'is_validation_error' => true, $status, $header, $options]);
    }
    
}
