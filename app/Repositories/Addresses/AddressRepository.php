<?php
namespace App\Repositories\Addresses;

use App\Http\Resources\Addresses\AddressIndexResource;
use App\Http\Resources\Addresses\AddressShortResource;
use App\Interfaces\Addresses\AddressInterface;
use App\Models\Address;
use Illuminate\Support\Facades\Storage;

class AddressRepository implements AddressInterface
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Address::query();
        $data->with(['created_user', 'updated_user']);
        $data->orderBy(request('sort_by'), request('sort_type'));
        return helper_response_fetch(AddressIndexResource::collection($data->paginate(request('per_page')))->resource);
    }

    public function all()
    {
        $data = Address::query();
        $data->orderByDesc('id');
        return helper_response_fetch(AddressShortResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = Address::create([
            'address' => $request->address,
        ]);

        return helper_response_created(new AddressIndexResource($data));
    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new AddressIndexResource($item));
    }

    public function update($request, $item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'address' => $request->address,
        ]);
        return helper_response_updated($item);
    }

    public function destroy($item): \Illuminate\Http\JsonResponse
    {
        $item->delete();
        return helper_response_deleted();
    }

//    public function searchable()
//    {
//        return helper_response_fetch(Address::searchable());
//    }
}
