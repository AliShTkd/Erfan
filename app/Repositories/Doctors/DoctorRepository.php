<?php
namespace App\Repositories\Doctors;

use App\Http\Resources\Doctors\DoctorIndexResource;
use App\Http\Resources\Doctors\DoctorShortResource;
use App\Interfaces\Doctors\DoctorInterface;
use App\Models\Doctor;

class DoctorRepository implements DoctorInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Doctor::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(DoctorIndexResource::collection($data->paginate(request('per_page')))->resource);

    }

    public function all()
    {
        $data = Doctor::query();
        $data->orderByDesc('id');
        return helper_response_fetch(DoctorShortResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = Doctor::create([
            'user_id' => $request->user_id,
            'specialty' => $request->specialty,
            'license_number' => $request->license_number,
            'address' => $request->address,
            'working_hours' => $request->working_hours,
            'bio' => $request->bio,
        ]);

        return helper_response_created(new DoctorIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new DoctorIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'user_id' => $request->user_id,
            'specialty' => $request->specialty,
            'license_number' => $request->license_number,
            'address' => $request->address,
            'working_hours' => $request->working_hours,
            'bio' => $request->bio,
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
//        return helper_response_fetch(Doctor::searchable());
//    }

}
