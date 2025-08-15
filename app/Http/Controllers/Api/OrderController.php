<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderResource; // <-- این خط را اضافه کنید
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * متد برای ایجاد سفارش از سبد خرید
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'سبد خرید شما خالی است.'], 400);
        }

        $order = DB::transaction(function () use ($user, $cartItems) {
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                if (!$item->product) continue;
                $totalAmount += $item->product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                if (!$item->product) continue;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $user->cartItems()->delete();

            return $order;
        });

        return response()->json([
            'message' => 'سفارش شما با موفقیت ثبت شد.',
            'order_id' => $order->id
        ], 201);
    }

    /**
     * متد برای نمایش همه سفارش‌های کاربر (اصلاح شده)
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();

        // از Resource Collection استفاده می‌کنیم تا خروجی فرمت‌بندی شود
        return OrderResource::collection($orders);
    }

    /**
     * متد برای نمایش جزئیات یک سفارش (اصلاح شده)
     */
    public function show(Order $order)
    {
        // اطمینان از اینکه کاربر فقط به سفارش خودش دسترسی دارد
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'دسترسی غیرمجاز'], 403);
        }

        $order->load('items.product');

        // از Resource برای یک آیتم استفاده می‌کنیم
        return new OrderResource($order);
    }
}
