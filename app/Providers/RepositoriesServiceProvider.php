<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Interfaces
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\ProfileRepositoryInterface;
use App\Contracts\User\RoleRepositoryInterface;
use App\Contracts\Item\CategoryRepositoryInterface;
use App\Contracts\Item\BrandRepositoryInterface;
use App\Contracts\Item\UnitRepositoryInterface;
use App\Contracts\Item\SupplierRepositoryInterface;

//Repositories
use App\Repositories\User\UserRepository;
use App\Repositories\User\ProfileRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\Item\CategoryRepository;
use App\Repositories\Item\BrandRepository;
use App\Repositories\Item\UnitRepository;
use App\Repositories\Item\SupplierRepository;

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
            CategoryRepositoryInterface::class,
            CategoryRepository::class,
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class,
        );

        $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class,
        );

        $this->app->bind(
            SupplierRepositoryInterface::class,
            SupplierRepository::class,
        );

        // $models = array(
        //     'User'
        // );

        // foreach ($models as $model) {
        //     $this->app->bind("App\Contracts\\{$model}Interface", "App\Repositories\\{$model}Repository");
        // }
    }
}
