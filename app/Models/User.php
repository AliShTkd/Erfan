<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded=[];


    protected static function booted(): void
    {
        static::creating(static function ($model) {
            $model->created_by = auth()->id();
        });
    }

//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }



    public function created_user():BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updated_user(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function user_group(): BelongsTo
    {
        return $this->belongsTo(user_group::class, 'group_id');
    }

    public function Carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public static function searchable()
    {
        $group =User_Group::select(['id as value','name as label'])->get();

        $fields = [

            [
                'label' => 'نام و نام خانوادگی کاربر',
                'field' => 'name',
                'type' => 'text'
            ],
            [
                'label' => 'ایمیل کاربر',
                'field' => 'email',
                'type' => 'text'
            ],
            [
                'label' => 'شماره موبایل کاربر',
                'field' => 'phone',
                'type' => 'text'
            ],
            [
                'label' => 'نام کاربری',
                'field' => 'username',
                'type' => 'text'
            ],
            [
                'label' => 'نقش کاربر',
                'field' => 'group_id',
                'type' => 'select',
                'items' => $group,
            ],

        ];
        return $fields;

    }

}
