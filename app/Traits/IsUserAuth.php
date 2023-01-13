<?php

namespace App\Traits;

trait IsUserAuth
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsUserAuth($query): mixed
    {
        return $query->where('user_id', auth()->id());
    }
}
