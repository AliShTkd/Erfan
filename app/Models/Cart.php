<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='cart';
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public static function searchable()
    {
        $user =User::select(['id as value','name as label','email as email'])->get();
        $product =Product::select(['id as value','name as label'])->get();

        $fields = [

            [
                'label' => 'شناسه کاربر',
                'field' => 'user_id',
                'type' => 'select',
                'items' => $user,
            ],
            [
                'label' => 'شناسه محصولات',
                'field' => 'product_id',
                'type' => 'select',
                'items' => $product,
            ],

        ];
        return $fields;

    }
}
