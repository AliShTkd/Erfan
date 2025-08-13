<?php
namespace App\Repositories\Products;

use App\Http\Resources\Products\ProductIndexResource;
use App\Http\Resources\Products\ProductShortResource;
use App\Interfaces\Products\ProductInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductInterface
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Product::query();
        $data->with(['created_user', 'updated_user']);
        $data->orderBy(request('sort_by'), request('sort_type'));
        return helper_response_fetch(ProductIndexResource::collection($data->paginate(request('per_page')))->resource);
    }

    public function all()
    {
        $data = Product::query();
        $data->orderByDesc('id');
        return helper_response_fetch(ProductShortResource::collection($data->get()));
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $imagePath = null;
        // ۱. بررسی می‌کنیم آیا فایلی برای 'image' آپلود شده است
        if ($request->hasFile('image')) {
            // ۲. فایل را در پوشه 'products' داخل دیسک 'public' ذخیره کن
            // و مسیر آن را برگردان
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $data = Product::create([
            'user_id' => $request->user_id ?? auth()->id(), // استفاده از user_id از درخواست یا احراز هویت
            'name' => $request->name,
            'entity' => $request->entity,
            'price' => $request->price,
            'image' => $imagePath, // ۳. مسیر ذخیره شده را در دیتابیس ثبت کن
            'description' => $request->description,
        ]);

        return helper_response_created(new ProductIndexResource($data));
    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        return helper_response_fetch(new ProductIndexResource($item));
    }

    public function update($request, $item): \Illuminate\Http\JsonResponse
    {
        $imagePath = $item->image; // مسیر عکس فعلی را نگه دار

        // ۱. اگر عکس جدیدی آپلود شده بود
        if ($request->hasFile('image')) {
            // ۲. اگر عکس قدیمی وجود داشت، آن را از حافظه پاک کن
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            // ۳. عکس جدید را ذخیره کن و مسیرش را بگیر
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $item->update([
            'user_id' => $request->user_id ?? auth()->id(),
            'name' => $request->name,
            'entity' => $request->entity,
            'price' => $request->price,
            'image' => $imagePath, // ۴. مسیر جدید (یا همان مسیر قبلی) را در دیتابیس آپدیت کن
            'description' => $request->description,
        ]);
        return helper_response_updated($item);
    }

    public function destroy($item): \Illuminate\Http\JsonResponse
    {
        // ۱. اگر محصول عکسی داشت، آن را از حافظه پاک کن
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        // ۲. خود محصول را از دیتابیس پاک کن
        $item->delete();
        return helper_response_deleted();
    }

    public function searchable()
    {
        return helper_response_fetch(Product::searchable());
    }
}
