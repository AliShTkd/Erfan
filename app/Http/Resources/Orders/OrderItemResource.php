<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Products\ProductIndexResource; // بسیار مهم
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price' => $this->price, // قیمت در لحظه خرید
            'product' => new ProductIndexResource($this->whenLoaded('product')),
        ];
    }
}

