<?php

namespace App\Http\Resources\User_Groups;

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
class UserGroupIndexResource extends JsonResource
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
            'name' => $this->name,
            'created_by' => new UserRelResource($this->created_user),
            'updated_by' => new UserRelResource($this->updated_user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
