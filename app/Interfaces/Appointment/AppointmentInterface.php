<?php
namespace App\Interfaces\Appointment;

use App\Models\Doctor;

interface AppointmentInterface
{
    public function index();

    public function myAppointments();

    public function store($request);

    public function show($item);

    public function cancel($item);

    public function checkDoctorAppointment(Doctor $doctor);

}

