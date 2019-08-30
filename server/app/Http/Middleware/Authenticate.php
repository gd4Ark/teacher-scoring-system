<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Authenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->checkForToken($request);
        try {
            if ($request->user = JWTAuth::parseToken()->authenticate()) {
                return $next($request);
            }
            throw new UnauthorizedHttpException('jwt-auth', '未登录');
        } catch (TokenExpiredException $exception) {
            try {
                $token = JWTAuth::refresh(JWTAuth::getToken());
                JWTAuth::setToken($token);
                $request->user = JWTAuth::authenticate($token);
                $request->headers->set(
                    'Authorization',
                    'Bearer ' . $token
                );
            } catch (JWTException $exception) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => '登录过期'
                    ]
                )->setStatusCode(401);
            }
        }
        return $this->setAuthenticationHeader($next($request), $token);
    }
}
