<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = array('success' => true, 'data' => $result, 'message' => $message);
        $headers = array('kepala' => 'kepalanya',);

        return response()->json($response, 200, $headers);
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = array('success' => false, 'message' => $error);
        // $headers = array('kepala' => 'kepalanya',);
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}