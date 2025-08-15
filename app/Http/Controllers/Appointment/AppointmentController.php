<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Interfaces\Appointment\AppointmentInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected AppointmentInterface $repository;

    public function __construct(AppointmentInterface $appointmentRepository)
    {
        // میدلور تکراری auth:api از اینجا حذف شد
        $this->middleware('generate_fetch_query_params')->only(['index', 'myAppointments']);
        $this->repository = $appointmentRepository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function myAppointments()
    {
        return $this->repository->myAppointments();
    }

    public function store(AppointmentStoreRequest $request)
    {
        return $this->repository->store($request);
    }

    public function show(Appointment $appointment)
    {
        return $this->repository->show($appointment);
    }

    public function cancel(Appointment $appointment)
    {
        return $this->repository->cancel($appointment);
    }

    public function checkDoctorAppointment(Doctor $doctor)
    {
        return $this->repository->checkDoctorAppointment($doctor);
    }
}
