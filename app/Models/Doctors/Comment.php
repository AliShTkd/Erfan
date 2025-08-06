<?php

namespace App\Models\Doctors;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='comments';
    protected $guarded=[];
    protected static function booted(): void
    {
        static::creating(static function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(static function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function created_user():BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updated_user(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
