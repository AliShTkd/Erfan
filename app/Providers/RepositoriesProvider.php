<?php

namespace App\Providers;

use App\Interfaces\Appointment\AppointmentInterface;
use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\Carts\CartInterface;
use App\Interfaces\Contact_Us\ContactUsInterface;
use App\Interfaces\Doctors\Comments\CommentInterface;
use App\Interfaces\Doctors\DoctorInterface;
use App\Interfaces\Products\ProductInterface;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Interfaces\Users\UserInterface;
use App\Repositories\Appointment\AppointmentRepository;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Carts\CartRepository;
use App\Repositories\Contact_Us\ContactUsRepository;
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
        $this->app->bind(ContactUsInterface::class,ContactUsRepository::class);
        $this->app->bind(AppointmentInterface::class,AppointmentRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

}
