<?php

namespace App\Http\Controllers\Auth;

use App\Facades\JsonOutputFaced;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Notifications\ForgotPasswordNotification;
use App\Repositories\AuthenticationRepository;
use App\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
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
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $user = $this->authenticationRepository->findByEmail($request->get('email'));
        $token = $this->authenticationRepository->recovery($user);
        $user->notify(new ForgotPasswordNotification($token));
        $message = __('auth.response.forgot_password');

        return JsonOutputFaced::setMessage($message)->response();
    }
}
