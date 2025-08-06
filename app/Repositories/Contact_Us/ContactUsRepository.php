<?php
namespace App\Repositories\Contact_Us;

use App\Http\Resources\Contact_Us\ContactUsIndexResource;
use App\Http\Resources\Contact_Us\ContactUsShortResource;
use App\Interfaces\Contact_Us\ContactUsInterface;
use App\Models\Contact_Us;
use App\Models\Product;

class ContactUsRepository implements ContactUsInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Contact_Us::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(ContactUsIndexResource::collection($data->paginate(request('per_page')))->resource);

    }

    public function all()
    {
        $data = Contact_Us::query();
        $data->orderByDesc('id');
        return helper_response_fetch(ContactUsShortResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = Contact_Us::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        return helper_response_created(new ContactUsIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new ContactUsIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);
        return helper_response_updated($item);

    }

    public function destroy($item): \Illuminate\Http\JsonResponse
    {
        $item->delete();
        return helper_response_deleted();
    }

   /* public function searchable()
    {
        return helper_response_fetch(Contact_Us::searchable());
    }*/

}
