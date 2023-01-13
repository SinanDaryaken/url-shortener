<?php

namespace App\Http\Middleware;

use App\Facades\JsonOutputFaced;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;


class JwtMiddleware extends BaseMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return JsonOutputFaced::setStatusCode(401)->setMessage(__('auth.jwt.token_expired'))->response();
            }
        } catch (TokenInvalidException $e) {
            return JsonOutputFaced::setStatusCode(401)->setMessage(__('auth.jwt.invalid_token'))->response();
        } catch (TokenExpiredException $e) {
            return JsonOutputFaced::setStatusCode(401)->setMessage(__('auth.jwt.token_expired'))->response();
        } catch (JWTException $e) {
            return JsonOutputFaced::setStatusCode(401)->setMessage(__('auth.jwt.token_not_found'))->response();
        }
        return $next($request);
    }
}
