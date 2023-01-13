<?php

namespace App\Services;

use App\Facades\JsonOutputFaced;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AuthenticationService
{
    /**
     * @param string $token
     * @return array
     */
    public function createNewToken(string $token): array
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource(Auth::user()),
        ];

        return $data;
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function refreshToken(string $token): JsonResponse
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];

        return JsonOutputFaced::setData($data)->response();
    }

    /**
     * @param User $user
     * @param string $token
     * @return string
     */
    public function encrypt(User $user, string $token): string
    {
        return Crypt::encryptString($user->email . '<-nono->' . $token);
    }
}
