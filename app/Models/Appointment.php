<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    // نام جدول بر اساس اسکرین‌شات دیتابیس شما اصلاح شد
    protected $table = 'appointment';

    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(static function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(static function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function created_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // این رابطه، کاربری که نوبت را رزرو کرده (بیمار) را برمی‌گرداند
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // این رابطه باید به مدل Doctor اشاره کند
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
