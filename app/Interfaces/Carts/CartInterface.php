<?php
namespace App\Interfaces\Carts;

interface CartInterface
{

    public function index();

    public function all();

    public function store($request);

    public function show($item);

    public function update($request,$item);

    public function destroy($item);

    public function searchable();

    public function add_to_cart();

    public function get_cart();


}

