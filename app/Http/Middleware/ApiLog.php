<?php

namespace App\Http\Middleware;

use Closure;
use Helper;
use Log;

class ApiLog
{
    const MAX_LENGTH = 1024;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $startTime = microtime(true);

        $rid = Helper::randomStr();

        $in = sprintf("[in: %s] curl -X %s '%s'", $rid, $request->method(), $request->url());

        if ($request->isMethod('post')) {
            $content = $request->getContent();
            if (strlen($content) <= self::MAX_LENGTH) {
                $in = sprintf("%s -d '%s'", $in, str_replace("'", "\'", $content));
            }
        }

        Log::channel('api')->debug($in);

        $response = $next($request);

        $content = $response->getContent();
        if (strlen($content) > self::MAX_LENGTH) {
            $content = '{omitted}';
        }

        $time = strval(round(microtime(true) - $startTime, 2));

        $out = sprintf("[out: %s] %s (%sms)", $rid, $content, $time * 1000);

        Log::channel('api')->debug($out);

        return $response;
    }
}
