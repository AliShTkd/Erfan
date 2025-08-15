<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    protected $table='order_items';
    protected $guarded = [];

    // این متد به صورت خودکار created_by و updated_by را پر می‌کند
    protected static function booted(): void
    {
        static::creating(static function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(static function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ====================================================================
    // START: تغییر کلیدی
    // ====================================================================
    public function product(): BelongsTo
    {
        // با افزودن withTrashed، حتی اگر محصول حذف شده باشد، اطلاعات آن در فاکتور نمایش داده می‌شود
        return $this->belongsTo(Product::class)->withTrashed();
    }
    // ====================================================================
    // END: تغییر کلیدی
    // ====================================================================

    public function created_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

