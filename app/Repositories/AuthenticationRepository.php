<?php

namespace App\Repositories;

use App\Interfaces\AuthenticationInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthenticationRepository implements AuthenticationInterface
{
    /**
     * @param User $user
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * @param User $user
     * @return string
     */
    public function recovery(User $user): string
    {
        $token = rand(100000, 999999);

        DB::table('password_resets')
            ->updateOrInsert(
                [
                    'email' => $user->email
                ],
                [
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => now()
                ]
            );

        return $token;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function recoverParametersMatch(array $data): bool
    {
        return DB::table('password_resets')->where('email', $data['email'])->where('token', $data['tokens'])->exists();
    }

    /**
     * @param array $data
     * @return void
     */
    public function updatePassword(array $data): void
    {
        unset($data['token']);
        $data['password'] = bcrypt($data['password']);
        $this->user->update(['email' => $data['email'], $data]);
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User
    {
        return $this->user->where('email', $email)->first();
    }

    /**
     * @param array $data
     * @return void
     */
    public function register(array $data): void
    {
        $this->user->create($data);
    }
}
