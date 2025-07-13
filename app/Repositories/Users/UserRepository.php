<?php
namespace App\Repositories\Users;

use App\Http\Resources\Auth\UserInfoAuthResource;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Interfaces\Users\UserInterface;
use App\Models\User;
use App\Models\User_Group;

class UserRepository implements UserInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = User_Group::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(User_GroupIndexResource::collection($data->paginate(request('per_page')))->resource);

    }



    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = User_Group::create([
            'unit_id' => $request->unit_id,
            'name' => $request->name,
            'type' => $request->type,
            'default' => $request->default,
            'description' => $request->description,
        ]);
        //create attributes
        if (is_array($request->items)){
            foreach ($request->items as $item){
                $data->attributes()->create([
                    'attribute' => $item
                ]);
            }
        }

        return helper_response_created(new User_GroupIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new User_GroupIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'unit_id' => $request->unit_id,
            'name' => $request->name,
            'type' => $request->type,
            'default' => $request->default,
            'description' => $request->description,
        ]);
        $item->attributes()->delete();
        if (is_array($request->items)){
            foreach ($request->items as $attribute){
                $item->attributes()->create([
                    'attribute' => $attribute
                ]);
            }
        }
        return helper_response_updated($item);

    }

    public function destroy($item): \Illuminate\Http\JsonResponse
    {
        $item->delete();
        return helper_response_deleted();
    }

}
