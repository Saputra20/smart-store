<?php

use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

if (!function_exists('successResponse')) { 
    function successResponse($message, $data, $code_status = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code_status);
    }
}

if(!function_exists('errorResponse')){
    function errorResponse($message, $data, $code_status = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error_code' => $code_status,
            'message' => $message,
            'data' => $data
        ], $code_status));
    }
}

/**
 * TODO
 *  Return costume format paginate
 * 
 * @return object
 */
if (!function_exists('pagintation')) {
    function pagination($data, $total, $request)
    {
        return [
            'rows' => $data,
            'meta' => [
                'total_data' => $total,
                'offset' => $request->offset,
                'limit' => $request->limit
            ]
        ];
    }
}

if (!function_exists('isValidRequest')) {
    function isValidRequest($request, $key)
    {
        return (($request->has($key)) && $request->$key != "");
    }
}
