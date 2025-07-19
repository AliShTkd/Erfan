<?php
namespace App\Repositories\Users;

use App\Http\Resources\Auth\UserInfoAuthResource;
use App\Http\Resources\Users\UserIndexResource;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Interfaces\Users\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = User::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(UserIndexResource::collection($data->paginate(request('per_page')))->resource);

    }



    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = User::create([
            'group_id' => $request->group_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'address' => $request->address,
            'description' => $request->description,
            'password' => \Hash::make($request->password),
        ]);

        return helper_response_created(new UserIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new UserIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'group_id' => $request->group_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'address' => $request->address,
            'description' => $request->description,
            'password' => \Hash::make($request->password),
        ]);
        return helper_response_updated($item);

    }

    public function destroy($item): \Illuminate\Http\JsonResponse
    {
        $item->delete();
        return helper_response_deleted();
    }

}
