<?php
/**
 * CORS route Middleware.
 */
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Response;
class CORSMiddleware
{
    private $headers;
    private $allow_origin;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
            //'Access-Control-Allow-Credentials' => 'true',//允许客户端发送cookie
            'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Last-Modified' => gmdate("D, d M Y H:i:s") . " GMT",
            'Cache-Control' => 'no-cache, must-revalidate',
            'Pragma' => 'no-cache',
        ];
        $this->allow_origin = [
            'http://localhost',
        ];
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
//        //如果origin不在允许列表内，直接返回403
//        if (!in_array($origin, $this->allow_origin) && !empty($origin))
//            return new Response('Forbidden', 403);
        if ($request->getMethod() == "OPTIONS") {
            //return Response::make('OK', 200, $this->headers);
            $response = new Response('OK', 200);
            foreach ($this->headers as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }
        $response = $next($request);
        foreach ($this->headers as $key => $value)
            $response->header($key, $value);
        return $response;
    }
}