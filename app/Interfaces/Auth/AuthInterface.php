<?php
namespace App\Interfaces\Auth;

interface AuthInterface
{

    public function register($request);

    public function users_login($request);

    public function user_logout();
    



}

