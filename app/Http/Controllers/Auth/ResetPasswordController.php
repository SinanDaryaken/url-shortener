<?php

namespace App\Http\Controllers\Auth;

use App\Facades\JsonOutputFaced;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Repositories\AuthenticationRepository;
use App\Services\AuthenticationService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    /**
     * @param AuthenticationRepository $authenticationRepository
     */
    public function __construct(
        private AuthenticationRepository $authenticationRepository,
    )
    {
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        try {
            if ($this->authenticationRepository->recoverParametersMatch($request->validated())) {
                $this->authenticationRepository->updatePassword($request->validated());
                return JsonOutputFaced::response();
            }
            return JsonOutputFaced::setStatusCode(406)->setMessage(__('auth.errors.token_match'))->response();
        } catch (DecryptException $e) {
            return JsonOutputFaced::setStatusCode(406)->setMessage(__('auth.errors.token_match'))->response();
        }
    }
}
