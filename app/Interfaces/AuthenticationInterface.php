<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthenticationInterface
{
    /**
     * @param User $user
     * @return string
     */
    public function recovery(User $user): string;

    /**
     * @param array $data
     * @return bool
     */
    public function recoverParametersMatch(array $data): bool;

    /**
     * @param array $data
     * @return void
     */
    public function updatePassword(array $data): void;

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User;

    /**
     * @param array $data
     * @return void
     */
    public function register(array $data): void;
}
