<?php
namespace App\Repositories\User_Groups;

use App\Http\Resources\Auth\UserInfoAuthResource;
use App\Http\Resources\User_Groups\UserGroupIndexResource;
use App\Http\Resources\User_Groups\UserGroupShortResource;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Models\User;
use App\Models\User_Group;

class UserGroupRepository implements UserGroupInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = User_Group::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(UserGroupIndexResource::collection($data->paginate(request('per_page')))->resource);

    }


    public function all(): \Illuminate\Http\JsonResponse
    {
        $data = User_Group::query();
        $data->orderByDesc('id');
        return helper_response_fetch(UserGroupShortResource::collection($data->get()));
    }
    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = User_Group::create([
            'name' => $request->name,
        ]);
        //create attributes


        return helper_response_created(new UserGroupIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new UserGroupIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'name' => $request->name,
        ]);

        return helper_response_updated($item);

    }

    public function destroy($item): \Illuminate\Http\JsonResponse
    {
        $item->delete();
        return helper_response_deleted();
    }

    public function searchable()
    {
        return helper_response_fetch(User_Group::searchable());
    }

}
