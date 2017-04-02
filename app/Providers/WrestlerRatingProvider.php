<?php

namespace App\Providers;

use App\Services\CommunityRatingsCompiler;
use App\Services\CommunityRatingsEraser;
use App\Services\ImageUploader;
use App\Services\Repositories\WrestlerRepository;
use App\Services\WrestlerRater;
use Illuminate\Support\ServiceProvider;

class WrestlerRatingProvider extends ServiceProvider
{

    public function register()
    {
        // community ratings compiler
        $this->app->bind('CommunityRatingsCompiler', function(){
            return new CommunityRatingsCompiler(new WrestlerRater, new WrestlerRepository(new ImageUploader));
        });

        // community ratings eraser
        $this->app->bind('CommunityRatingsEraser', function(){
            return new CommunityRatingsEraser(new WrestlerRepository(new ImageUploader));
        });
    }
}
