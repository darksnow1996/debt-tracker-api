<?php

namespace App\Providers;

use App\Repositories\ApiRepository;
use App\Repositories\Contracts\ApiRepositoryContract;
use App\Repositories\Contracts\FixtureRepositoryContract;
use App\Repositories\Contracts\InHousePredictionRepositoryContract;
use App\Repositories\Contracts\PredictionRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\FixtureRepository;
use App\Repositories\InHousePredictionRepository;
use App\Repositories\PredictionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(ApiRepositoryContract::class, ApiRepository::class);
        $this->app->bind(InHousePredictionRepositoryContract::class, InHousePredictionRepository::class);
        $this->app->bind(PredictionRepositoryContract::class, PredictionRepository::class);
        $this->app->bind(FixtureRepositoryContract::class, FixtureRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
