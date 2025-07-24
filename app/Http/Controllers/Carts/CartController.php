<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Carts\CartCreateRequest;
use App\Http\Requests\Carts\CartUpdateRequest;
use App\Interfaces\Carts\CartInterface;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartInterface $repository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->middleware('generate_fetch_query_params')->only('index');
        $this->repository = $cartRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->repository->index();
    }

    public function all()
    {
        return $this->repository->all();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CartCreateRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return $this->repository->show($cart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartUpdateRequest $request, Cart $cart)
    {
        return $this->repository->update($request, $cart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        return $this->repository->destroy($cart);
    }

    public function searchable()
    {
        return $this->repository->searchable();
    }
}
