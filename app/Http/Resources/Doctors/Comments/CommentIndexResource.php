<?php

namespace App\Http\Resources\Doctors\Comments;

use App\Http\Resources\Doctors\DoctorShortResource;
use App\Http\Resources\User_Groups\UserGroupShortResource;
use App\Http\Resources\Users\UserRelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $profile
 * @property mixed $config
 */
class CommentIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor' => new DoctorShortResource($this->doctor),
            'rating' => $this->rating,
            'comment' => $this->comment,
            'status' => $this->status,
            'created_by' => new UserRelResource($this->created_user),
            'updated_by' => new UserRelResource($this->updated_user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
