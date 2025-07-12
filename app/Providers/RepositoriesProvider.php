<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\User_Groups\UserGroupRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(UserGroupInterface::class,UserGroupRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

}
