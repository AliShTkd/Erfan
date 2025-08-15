<?php

namespace App\Http\Controllers\Doctors\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctors\Comments\CommentCreateRequest;
use App\Http\Requests\Doctors\Comments\CommentUpdateRequest;
use App\Interfaces\Doctors\Comments\CommentInterface;
use App\Models\Doctors\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentInterface $repository;

    public function __construct(CommentInterface $commentRepository)
    {
        $this->middleware('generate_fetch_query_params')->only('index');
        $this->repository = $commentRepository;
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
    public function store(CommentCreateRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return $this->repository->show($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        return $this->repository->update($request, $comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        return $this->repository->destroy($comment);
    }
}
