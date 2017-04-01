<?php

namespace App\Providers;

use App\Services\CommunityRatingsCompiler;
use App\Services\Repositories\WrestlerRepository;
use App\Services\WrestlerRater;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
