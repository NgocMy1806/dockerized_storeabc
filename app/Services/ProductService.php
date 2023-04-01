<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductService extends BaseService
{
    public function getProducts($request)
    {

        $query = Product::query();

        $query->with([
            'thumbnail',
            'category'
        ]);

        if ($request->cat_filter) {
            $query->whereHas('category', function ($sql) use ($request) {
                return $sql->where('id', $request->cat_filter);
            });
        }

        if ($request->text_search) {
            $query->where('name', 'like', "%$request->text_search%");
        }

        if ($request->sort_key == 'az') {
            $query->orderBy('name', 'ASC');
        }
        if ($request->sort_key == 'za') {
            $query->orderBy('name', 'DESC');
        }
        if ($request->sort_key == 'price_up') {
            $query->orderBy('price', 'ASC');
        }
        if ($request->sort_key == 'price_down') {
            $query->orderBy('price', 'DESC');
        }

        return $query->paginate(10);
    }


    // return $query->paginate(10);

    //return Product::with(['thumbnail'])->paginate(10);

    public function getProductDetail($request)
    {
        return $product = Product::where('id', $request)->first();
    }
    public function getThumbnail($request)
    {
        $thumbnail = Media::where([['mediable_id', $request], ['mediable_type', 'App\Models\Product'], ['type', 'thumbnail']])->first();
        return $thumbnail;
        // dd($thumbnail);
        // $images=Media::where([['mediable_id',$request], ['mediable_type','App\Models\Product'],['type','image']])->get();
    }
    public function getImages($request)
    {
        $images = Media::where([['mediable_id', $request], ['mediable_type', 'App\Models\Product'], ['type', 'product_image']])->get();
        return $images;
    }

    public function store_thumb_and_image($id, $request)
    {
        $product = Product::find((int) $id);
        if ($request->hasFile('thumbnail')) {
            $fileName = Carbon::now()->format('H_i_s') . '-' . $request->file('thumbnail')->getClientOriginalName();
            Media::create([
                'mediable_type' => Product::class,
                'mediable_id' => $product->id,
                'type' => 'thumbnail',
                'name' => $fileName,
            ]);
            $request->file('thumbnail')->storeAs('public/thumbnail', $fileName);
        }
        if (is_array($request->images)) {
            foreach ($request->images as $image) {
                $fileName = Carbon::now()->format('H_i_s') . '-' . $image->getClientOriginalName();
                Media::create([
                    'mediable_type' => Product::class,
                    'mediable_id' => $product->id,
                    'type' => 'product_image',
                    'name' => $fileName,
                ]);

                $image->storeAs('public/images', $fileName);
            }
        }
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();
            // dd(($request->hasFile('thumbnail')));
            // (!isset($request->is_active));
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'stock' => $request->stock ?? 0,
                'price' => $request->price ?? 0,
                'sale_price' => $request->sale_price ?? 0,
                'category_id' => $request->category_id ?? '',
                'description' => $request->description ?? '',
                'content' => $request->content ?? '',
                'is_active' => !isset($request->is_active) ? 0 : 1,
                'is_hot' => !isset($request->is_hot) ? 0 : 1,
            ]);
            $id = $product->id;
            // dd($id);
            $this->store_thumb_and_image($id, $request);
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }


    //del existing thumbnail and image of product
    public function del_Thumb_and_images($id)
    {
        $product = Product::find($id);
        if (!empty($product->thumbnail)) {
            Storage::disk('public')->delete('thumbnail/' . $product->thumbnail->name);
            $product->thumbnail->delete();
        }
        $images = Media::where([['mediable_id', $id], ['mediable_type', 'App\Models\Product'], ['type', 'product_image']])->get();
        if (!empty($images)) {
            // dd($product->images);
            foreach ($images as $image) {
                // dd($image->name);
                Storage::disk('public')->delete('images/' . $image->name);
                $image->delete();
            }
        }
    }

    public function update($id, $request)
    {

        try {
            DB::beginTransaction();
            $product = Product::find((int) $id);
            
            // dd($request->category_id);
            //del existing thumbnail and image of product
            $this->del_Thumb_and_images($id);
            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'stock' => $request->stock ?? 0,
                'price' => $request->price ?? 0,
                'sale_price' => $request->sale_price ?? 0,
                'category_id' => $request->category_id ?? 0,
                'description' => $request->description ?? null,
                'content' => $request->content ?? '',
                'is_active' => !isset($request->is_active) ? 0 : 1,
                'is_hot' => !isset($request->is_hot) ? 0 : 1,
            ]);

            $this->store_thumb_and_image($id, $request);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }


    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            $this->del_Thumb_and_images($id);
            //dd($product->thumbnail );
            // if (!empty($product->thumbnail)) {
            //     Storage::disk('public')->delete('thumbnail/' . $product->thumbnail->name);
            //     $product->thumbnail->delete();
            // }
            // $images = Media::where([['mediable_id', $id], ['mediable_type', 'App\Models\Product'], ['type', 'product_image']])->get();
            // if (!empty($images)) {
            //     // dd($product->images);
            //     foreach ($images as $image) {
            //         // dd($image->name);
            //         Storage::disk('public')->delete('images/' . $image->name);
            //         $image->delete();
            //     }
            // }


            $product->delete();
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }
}
