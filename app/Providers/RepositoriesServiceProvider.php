<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Interfaces
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\ProfileRepositoryInterface;
use App\Contracts\User\RoleRepositoryInterface;
use App\Contracts\Item\GeneralRepositoryInterface;
use App\Contracts\Item\ItemRepositoryInterface;
use App\Contracts\Pos\CartRepositoryInterface;

//Repositories
use App\Repositories\User\UserRepository;
use App\Repositories\User\ProfileRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\Item\GeneralRepository;
use App\Repositories\Item\ItemRepository;
use App\Repositories\Pos\CartRepository;

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

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class,
        );

        $this->app->bind(
            GeneralRepositoryInterface::class,
            GeneralRepository::class,
        );

        $this->app->bind(
            ItemRepositoryInterface::class,
            ItemRepository::class,
        );

        
        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class,
        );

        // $models = array(
        //     'User'
        // );

        // foreach ($models as $model) {
        //     $this->app->bind("App\Contracts\\{$model}Interface", "App\Repositories\\{$model}Repository");
        // }
    }
}
