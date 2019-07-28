<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 通用 API 错误代码定义
     */
    const SUCCEED         = 200; // 响应成功
    const AUTH_FAILED     = 401; // 认证失败
    const FORBIDDEN       = 403; // 禁止访问
    const INVALID_REQUEST = 404; // 无效请求
    const INTERNAL_ERROR  = 500; // 内部错误
    const PARAM_ERROR     = 600; // 参数错误
    const PARAM_MISSING   = 601; // 参数缺失

    public function requireParams($required)
    {
        $required = is_array($required) ? $required : func_get_args();

        foreach ($required as $key) {
            if (!request()->has($key)) {
                return $this->response(self::PARAM_MISSING, "Missing param [$key]");
            }
        }
    }

    public function response($code, $message = null, $data = null)
    {
        return response()->json([
            'code'      => (int) $code,
            'message'   => $message,
            'data'      => $data,
            'timestamp' => time(),
        ]);
    }

    public function error($message = null, $data = null)
    {
        return $this->response(self::INTERNAL_ERROR, $message, $data);
    }

    public function success($message = null, $data = null)
    {
        return $this->response(self::SUCCEED, $message, $data);
    }

    public function setRedirectPath($url)
    {
        if (empty($url)) {
            $url = '/';
        }
        session(['redirect' => $url]);
    }

    public function getRedirectPath($default = '/')
    {
        // Remove the redirect item from the session and returning its value.
        $url = app('session')->remove('redirect');
        return $url ? $url : $default;
    }
}
