<?php
namespace App\Repositories\Doctors\Comments;

use App\Http\Resources\Doctors\Comments\CommentIndexResource;
use App\Http\Resources\Doctors\Comments\CommentShortResource;
use App\Interfaces\Doctors\Comments\CommentInterface;
use App\Models\Doctors\Comment;

class CommentRepository implements CommentInterface
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Comment::query();
        $data->with(['created_user','updated_user']);
        $data->orderBy(request('sort_by'),request('sort_type'));
        return helper_response_fetch(CommentIndexResource::collection($data->paginate(request('per_page')))->resource);

    }

    public function all()
    {
        $data = Comment::query();
        $data->where('doctor_id',request('doctor_id'));
        $data->orderByDesc('id');
        return helper_response_fetch(CommentIndexResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $data = Comment::create([
            'doctor_id' => $request->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return helper_response_created(new CommentIndexResource($data));

    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new CommentIndexResource($item));
    }

    public function update($request,$item): \Illuminate\Http\JsonResponse
    {
        $item->update([
            'doctor_id' => $request->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
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
//        return helper_response_fetch(Comment::searchable());
//    }

}
