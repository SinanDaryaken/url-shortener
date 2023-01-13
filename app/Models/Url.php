<?php

namespace App\Models;

use App\Traits\IsUserAuth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends Model
{
    use SoftDeletes, IsUserAuth;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'link',
        'slug',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
