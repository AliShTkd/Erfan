<?php
namespace App\Repositories\Auth;

use App\Http\Resources\Auth\UserInfoAuthResource;
use App\Interfaces\Auth\AuthInterface;
use App\Models\User;

class AuthRepository implements AuthInterface
{

    public function register($request)
    {
        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'group_id' => 3,
            'phone' => $request->phone,
        ]);
        //$user->update(['code' => helper_core_code_generator($user->id)]);
        $token = auth('api')->login($user);
        $data = [
            'user' => $user,
            'token' => $token,
        ];
        return response_success($data);
    }

    public function users_login($request)
    {
        //login users
        //check username and password
        if (! $token = auth('api')->attempt(request(['email', 'password']))){
            return helper_response_unauthorized();
        }
        $user = auth('api')->user();
        return helper_response_main('user login success',[
            'token' => $token,
            'user' => (new UserInfoAuthResource($user)),
            'token_type' => 'Bearer'
        ]);
    }

    public function user_logout()
    {
        $user = auth('api')->user();
        auth('api')->logout();
        return helper_response_main('user logout success', new UserInfoAuthResource($user)); 
    }


}
