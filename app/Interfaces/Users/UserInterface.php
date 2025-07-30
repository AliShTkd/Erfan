<?php
namespace App\Interfaces\Users;

interface UserInterface
{

    public function index();

    public function all();

    public function doctors();

    public function store($request);

    public function show($item);

    public function update($request,$item);

    public function destroy($item);

    public function searchable();

}

