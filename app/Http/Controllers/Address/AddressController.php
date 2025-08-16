<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addresses\AddressCreateRequest;
use App\Http\Requests\Addresses\AddressUpdateRequest;
use App\Interfaces\Addresses\AddressInterface;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected AddressInterface $repository;

    public function __construct(AddressInterface $addressRepository)
    {
        $this->middleware('generate_fetch_query_params')->only('index');
        $this->repository = $addressRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->repository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressCreateRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        return $this->repository->show($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressUpdateRequest $request, Address $address)
    {
        return $this->repository->update($request, $address);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        return $this->repository->destroy($address);
    }
}
