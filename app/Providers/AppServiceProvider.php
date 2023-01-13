<?php

namespace App\Providers;

use App\Services\JsonOutputService;
use App\Services\SlugService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('json_output_service', function () {
            return new JsonOutputService();
        });

        $this->app->bind('slug_exists_service', function () {
            return new SlugService();
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
