<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function throwException($e) {
        Log::debug($e->getMessage());
        return response()->json([
            'state' => 0,
            'errMsg' => $e->getMessage(),
        ]);
    }

    protected function successfulRes($data) {
        return response()->json([
            'state' => 1,
            'data' => $data,
        ]);
    }

    protected function checkParaOfRequest($request, $parameters) {
        foreach ($parameters as $parameter) {
            if ($request->input($parameter) === null) {
                if ($parameter == 'token') {
                    throw new Exception('Please login or refresh page.');
                }
                else {
                    throw new Exception('Need ' . $parameter);
                }
            }
        }
        return true;
    }
}
