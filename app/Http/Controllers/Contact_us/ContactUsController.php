<?php

namespace App\Http\Controllers\Contact_us;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact_Us\ContactUsCreateRequest;
use App\Http\Requests\Contact_Us\ContactUsUpdateRequest;
use App\Interfaces\Contact_Us\ContactUsInterface;
use App\Models\Contact_Us;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected ContactUsInterface $repository;

    public function __construct(ContactUsInterface $contactusRepository)
    {
        $this->middleware('generate_fetch_query_params')->only('index');
        $this->repository = $contactusRepository;
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
    public function store(ContactUsCreateRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact_Us $contact_us)
    {
        return $this->repository->show($contact_us);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactUsUpdateRequest $request, Contact_Us $contact_us)
    {
        return $this->repository->update($request, $contact_us);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact_Us $contact_us)
    {
        return $this->repository->destroy($contact_us);
    }
}
