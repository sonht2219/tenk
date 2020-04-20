<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 12/31/19
 * Time: 10:51 AM
 */

use App\Exceptions\ExecuteException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

if (!function_exists("restful_success")) {
    function restful_success($data, $is_multi = false, $meta = null, $message = null)
    {
        $res = [
            'status' => 1,
            'message' => $message ? $message : __('messages.success')
        ];
        if ($is_multi) {
            $res['datas'] = $data;
        } else {
            $res['data'] = $data;
        }
        if ($meta) {
            $res['meta'] = $meta;
        }
        return response()->json($res);
    }
}

if (!function_exists("restful_error")) {
    function restful_error($message = null, $status = 404, $trace = null, $special = 0)
    {
        if (!$message) $message = __('messages.failed');
        $res = [
            'status' => 0,
            'message' => $message
        ];

        if ($special) {
            $res['status'] = $special;
        }

        if ($trace) {
            $res['trace'] = $trace;
        }
        return response()->json($res, $status);
    }
}

if (!function_exists("restful_exception")) {
    function restful_exception(Exception $exception)
    {
//        return response()->json($exception->getTrace());
        if ($exception instanceof AuthenticationException) {
            return restful_error(__('messages.unauthorized'), 401);
        } elseif ($exception instanceof ValidationException) {
            return restful_error($exception->validator->errors()->first());
        } elseif ($exception instanceof ExecuteException) {
            return restful_error($exception->getMessage(), $exception->getCode());
        } else {
            return restful_error(
                config('app.debug') ? $exception->getMessage() : __('messages.failed'),
                404,
                config('app.debug') ? $exception->getTrace() : null
            );
        }
    }
}
