<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\Carts\CartInterface;
use App\Interfaces\Doctors\Comments\CommentInterface;
use App\Interfaces\Doctors\DoctorInterface;
use App\Interfaces\Products\ProductInterface;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Interfaces\Users\UserInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Carts\CartRepository;
use App\Repositories\Doctors\Comments\CommentRepository;
use App\Repositories\Doctors\DoctorRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\User_Groups\UserGroupRepository;
use App\Repositories\Users\UserRepository;
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
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(ProductInterface::class,ProductRepository::class);
        $this->app->bind(DoctorInterface::class,DoctorRepository::class);
        $this->app->bind(CartInterface::class,CartRepository::class);
        $this->app->bind(CommentInterface::class,CommentRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

}
