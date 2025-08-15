<?php

namespace App\Http\Resources\Appointment;

use App\Http\Resources\User_Groups\UserGroupShortResource;
use App\Http\Resources\Users\UserRelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;// تاریخ به هجری شمسی

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $profile
 * @property mixed $config
 */
class AppointmentIndexResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => new UserRelResource($this->user),
            'doctor_id' => $this->doctor_id,
            'doctor' => new UserRelResource($this->doctor),
            'appointment_time' => $this->appointment_time,
            'duration_minutes' => $this->duration_minutes,
            'appointment_time_fa' => Jalalian::fromCarbon($this->appointment_time)->format('Y/m/d ساعت H:i'),
            'status' => $this->status,
            'notes' => $this->notes,
            'created_by' => new UserRelResource($this->created_user),
            'updated_by' => new UserRelResource($this->updated_user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
