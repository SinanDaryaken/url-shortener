<?php

namespace App\Http\Controllers\Auth;

use App\Facades\JsonOutputFaced;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthenticationRepository;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * @param AuthenticationRepository $authenticationRepository
     */
    public function __construct(
        private AuthenticationRepository $authenticationRepository
    )
    {
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->authenticationRepository->register($request->validated());
        return JsonOutputFaced::response();
    }
}
