<?php

namespace App\Http\Controllers\User_Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User_Groups\UserGroupCreateRequest;
use App\Http\Requests\User_Groups\UserGroupUpdateRequest;
use App\Interfaces\User_Groups\UserGroupInterface;
use App\Models\User_Group;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{

    protected UserGroupInterface $repository;

    public function __construct(UserGroupInterface $userGroupRepository)
    {
        $this->middleware('generate_fetch_query_params')->only('index');
        $this->repository = $userGroupRepository;
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
    public function store(UserGroupCreateRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(User_Group $group)
    {
        return $this->repository->show($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserGroupUpdateRequest $request, User_Group $group)
    {
        return $this->repository->update($request, $group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_Group $group)
    {
        return $this->repository->destroy($group);
    }
}
