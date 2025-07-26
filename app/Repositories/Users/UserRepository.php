<?php
namespace App\Repositories\Users;

use App\Http\Resources\Users\UserIndexResource;
use App\Http\Resources\Users\UserShortResource;
use App\Interfaces\Users\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{

//    public function index(): \Illuminate\Http\JsonResponse
//    {
//        $data = User::query();
//        $data->with(['created_user','updated_user']);
//        $data->orderBy(request('sort_by'),request('sort_type'));
//        return helper_response_fetch(UserIndexResource::collection($data->paginate(request('per_page')))->resource);
//
//    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = User::query();
        $data->with(['created_user', 'updated_user']);

        // گرفتن فیلدهای قابل جستجو از مدل
        $searchableFields = User::searchable();

        // اعمال فیلترهای جستجو
        foreach ($searchableFields as $field) {
            $fieldName = $field['field'];
            $fieldType = $field['type'];

            // بررسی وجود پارامتر جستجو برای این فیلد
            if ($value = request($fieldName)) {
                if ($fieldType === 'text') {
                    $data->where($fieldName, 'like', '%' . $value . '%');
                } elseif ($fieldType === 'select') {
                    $data->where($fieldName, $value);
                }
            }
        }

        // اعمال مرتب‌سازی
        $data->orderBy(request('sort_by', 'id'), request('sort_type', 'desc'));

        // بازگشت پاسخ با pagination
        return helper_response_fetch(UserIndexResource::collection($data->paginate(request('per_page', 10)))->resource);
    }

    public function all(): \Illuminate\Http\JsonResponse
    {
        $data = User::query();
        $data->orderByDesc('id');
        return helper_response_fetch(UserShortResource::collection($data->get()));
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

    public function searchable()
    {
        return helper_response_fetch(User::searchable());
    }

}
