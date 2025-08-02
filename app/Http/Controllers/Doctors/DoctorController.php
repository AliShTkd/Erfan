<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctors\DoctorCreateRequest;
use App\Http\Requests\Doctors\DoctorUpdateRequest;
use App\Interfaces\Doctors\DoctorInterface;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected DoctorInterface $repository;

    public function __construct(DoctorInterface $doctorRepository)
    {
        $this->middleware('generate_fetch_query_params')->only('index');
        $this->repository = $doctorRepository;
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
    public function store(DoctorCreateRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return $this->repository->show($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {
        return $this->repository->update($request, $doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        return $this->repository->destroy($doctor);
    }
}
