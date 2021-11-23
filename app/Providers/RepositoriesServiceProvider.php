<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Interfaces
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\ProfileRepositoryInterface;
use App\Contracts\User\RoleRepositoryInterface;
use App\Contracts\ItemRepositoryInterface;
use App\Contracts\CartRepositoryInterface;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;
use App\Contracts\ReportRepositoryInterface;

//Repositories
use App\Repositories\User\UserRepository;
use App\Repositories\User\ProfileRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\ItemRepository;
use App\Repositories\CartRepository;

use App\Repositories\BaseRepository;
use App\Repositories\FilterRepository;
use App\Repositories\ReportRepository;

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
            ItemRepositoryInterface::class,
            ItemRepository::class,
        );

        
        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class,
        );

        $this->app->bind(
            BaseRepositoryInterface::class,
            BaseRepository::class,
        );

        $this->app->bind(
            FilterRepositoryInterface::class,
            FilterRepository::class,
        );

        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class,
        );

        // $models = array(
        //     'User'
        // );

        // foreach ($models as $model) {
        //     $this->app->bind("App\Contracts\\{$model}Interface", "App\Repositories\\{$model}Repository");
        // }
    }
}
