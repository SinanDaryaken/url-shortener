<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self isExists(string $slug)
 * @see \App\Services\SlugService
 */
class SlugExistsFaced extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'slug_exists_service';
    }
}
