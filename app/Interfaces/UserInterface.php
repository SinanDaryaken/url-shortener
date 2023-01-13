<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    /**
     * @return Collection
     */
    public function getUsersTimezone(): Collection;
}
