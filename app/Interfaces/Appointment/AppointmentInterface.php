<?php
namespace App\Interfaces\Appointment;

interface AppointmentInterface
{
    public function index();

    public function myAppointments();

    public function store($request);

    public function show($item);

    public function cancel($item);

}

