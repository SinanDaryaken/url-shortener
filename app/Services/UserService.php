<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserService
{
    /**
     * @param User $user
     * @return UserResource
     */
    public function setSingle(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @param Collection $users
     * @return JsonResource
     */
    public function setPlural(Collection $users): JsonResource
    {
        return UserResource::collection($users);
    }
}
