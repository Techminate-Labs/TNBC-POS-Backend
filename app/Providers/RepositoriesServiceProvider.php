<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Interfaces
use App\Contracts\UserRepositoryInterface;
use App\Contracts\ProfileRepositoryInterface;

//Repositories
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepository;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class,
        );

        // $models = array(
        //     'User'
        // );

        // foreach ($models as $model) {
        //     $this->app->bind("App\Contracts\\{$model}Interface", "App\Repositories\\{$model}Repository");
        // }
    }
}
