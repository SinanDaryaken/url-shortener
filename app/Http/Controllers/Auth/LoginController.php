<?php

namespace App\Http\Controllers\Auth;

use App\Facades\JsonOutputFaced;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * @param AuthenticationService $authenticationService
     */
    public function __construct(
        private AuthenticationService $authenticationService,
    )
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return JsonOutputFaced::setStatusCode(404)
                ->setMessage(__('auth.errors.failed'))
                ->response();
        }
        $data = $this->authenticationService->createNewToken($token);

        return JsonOutputFaced::setData($data)->response();
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return JsonOutputFaced::setMessage(__('auth.jwt.invalid_token'))->setStatusCode(401)->response();
            }
            JWTAuth::invalidate(JWTAuth::getToken());
            Auth::logout();
            return JsonOutputFaced::setMessage(__('auth.response.logout'))->setStatusCode(401)->response();
        } catch (TokenExpiredException) {
            try {
                return JsonOutputFaced::setMessage(__('auth.response.logout'))->response();
            } catch (TokenExpiredException|TokenBlacklistedException $exception) {
                return JsonOutputFaced::setMessage($exception->getMessage())->setStatusCode(401)->response();
            }
        } catch (\Exception $exception) {
            return JsonOutputFaced::setMessage($exception->getMessage())->response();
        }
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return JsonOutputFaced::setStatusCode(401)->setMessage(__('auth.jwt.invalid_token'))->response();
            }
            $token = JWTAuth::refresh();
            return $this->authenticationService->refreshToken($token);
        } catch (TokenExpiredException) {
            try {
                $token = JWTAuth::refresh();
                return $this->authenticationService->refreshToken($token);
            } catch (TokenExpiredException|TokenBlacklistedException $exception) {
                return JsonOutputFaced::setStatusCode(401)->setMessage($exception->getMessage())->response();
            }
        } catch (\Exception $e) {
            return JsonOutputFaced::setStatusCode(401)->setMessage($e->getMessage())->response();
        }
    }
}
