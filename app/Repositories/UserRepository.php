<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    /**
     * @param User $user
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * @return Collection
     */
    public function getUsersTimezone(): Collection
    {
        return $this->user->get()->groupBy('timezone');
    }
}
