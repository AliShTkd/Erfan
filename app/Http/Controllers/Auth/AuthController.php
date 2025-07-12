<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Interfaces\Auth\AuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected AuthInterface $repository;

    public function __construct(AuthInterface $auth)
    {
        $this->repository = $auth;
    }

    public function register(UserRegisterRequest $request)
    {
        return $this->repository->register($request);
    }
    public function login(UserLoginRequest $request)
    {
        return $this->repository->users_login($request);
    }





}
