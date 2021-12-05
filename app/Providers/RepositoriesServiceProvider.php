<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Interfaces
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

use App\Contracts\ItemRepositoryInterface;
use App\Contracts\CartRepositoryInterface;

use App\Contracts\ReportRepositoryInterface;

use App\Contracts\DashboardRepositoryInterface;

//Repositories
use App\Repositories\BaseRepository;
use App\Repositories\FilterRepository;

use App\Repositories\ItemRepository;
use App\Repositories\CartRepository;

use App\Repositories\ReportRepository;

use App\Repositories\DashboardRepository;

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
            BaseRepositoryInterface::class,
            BaseRepository::class,
        );

        $this->app->bind(
            FilterRepositoryInterface::class,
            FilterRepository::class,
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
            ReportRepositoryInterface::class,
            ReportRepository::class,
        );

        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepository::class,
        );

        // $models = array(
        //     'User'
        // );

        // foreach ($models as $model) {
        //     $this->app->bind("App\Contracts\\{$model}Interface", "App\Repositories\\{$model}Repository");
        // }
    }
}
