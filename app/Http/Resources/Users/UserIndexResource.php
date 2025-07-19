<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\User_Groups\UserGroupShortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $profile
 * @property mixed $config
 */
class UserIndexResource extends JsonResource
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
            'group_id' => $this->group_id,
            'name' => $this->name,
            'email ' => $this->email,
            'phone' => $this->phone,
            'username ' => $this->username,
            'address ' => $this->address,
            'group' => new UserGroupShortResource($this->group_user),
            'created_by' => new UserRelResource($this->created_user),
            'updated_by' => new UserRelResource($this->updated_user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
