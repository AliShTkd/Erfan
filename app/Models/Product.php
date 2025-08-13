<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='products';
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

    // START: بخش اضافه شده برای مدیریت آدرس عکس
    /**
     * یک اتربیوت مجازی برای گرفتن URL کامل عکس ایجاد می‌کند.
     * با این کار می‌توانید در API Resource یا Blade از $product->image_url استفاده کنید.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // اگر فیلد image در دیتابیس مقدار داشت، URL کامل آن را بساز
                if ($this->image) {
                    return Storage::disk('public')->url($this->image);
                }

                // در غیر این صورت، یک آدرس عکس پیش‌فرض برگردان
                // شما باید این عکس پیش‌فرض را در پوشه public/images قرار دهید
                return asset('images/default-product.png');
            }
        );
    }
    // END: بخش اضافه شده برای مدیریت آدرس عکس

    public static function searchable()
    {
        $user =User::select(['id as value','name as label','email as email'])->get();

        $fields = [

            [
                'label' => 'عنوان محصول',
                'field' => 'name',
                'type' => 'text'
            ],
            [
                'label' => 'موجودی',
                'field' => 'entity',
                'type' => 'text'
            ],
            [
                'label' => 'قیمت محصولات',
                'field' => 'price',
                'type' => 'text'
            ],
            [
                'label' => 'شناسه کاربر',
                'field' => 'user_id',
                'type' => 'select',
                'items' => $user,
            ],

        ];
        return $fields;

    }



}
