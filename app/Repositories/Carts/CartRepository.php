<?php
namespace App\Repositories\Carts;

use App\Http\Resources\Carts\CartIndexResource;
use App\Http\Resources\Carts\CartShortResource;
use App\Http\Resources\Products\ProductIndexResource;
use App\Interfaces\Carts\CartInterface;
use App\Interfaces\Products\ProductInterface;
use App\Models\Cart;

class CartRepository implements CartInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Cart::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(CartIndexResource::collection($data->paginate(request('per_page')))->resource);

    }

    public function all()
    {
        $data = Cart::query();
        $data->orderByDesc('id');
        return helper_response_fetch(CartShortResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = Cart::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'address' => $request->address,
        ]);

        return helper_response_created(new CartIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new CartIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'address' => $request->address,
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
        return helper_response_fetch(Cart::searchable());
    }

    public function add_to_cart()
    {
       $data = auth('api')->user()->carts()->create([
            'product_id' => request('product_id'),
            'quantity' => request('quantity'),
           'total_price' => request('total_price'),
        ]);
       return response_success();
    }

    public function get_cart()
    {
        $data = auth('api')->user()->carts();
        $data->with('product');
        return helper_response_fetch($data->get());
    }


}
