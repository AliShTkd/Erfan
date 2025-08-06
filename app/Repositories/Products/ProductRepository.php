<?php
namespace App\Repositories\Products;

use App\Http\Resources\Products\ProductIndexResource;
use App\Http\Resources\Products\ProductShortResource;
use App\Interfaces\Products\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Product::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(ProductIndexResource::collection($data->paginate(request('per_page')))->resource);

    }

    public function all()
    {
        $data = Product::query();
        $data->orderByDesc('id');
        return helper_response_fetch(ProductShortResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = Product::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'entity' => $request->entity,
            'price' => $request->price,
            'image' => $request->image,
            'description' => $request->description,
        ]);

        return helper_response_created(new ProductIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new ProductIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'entity' => $request->entity,
            'price' => $request->price,
            'image' => $request->image,
            'description' => $request->description,
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
        return helper_response_fetch(Product::searchable());
    }

}
