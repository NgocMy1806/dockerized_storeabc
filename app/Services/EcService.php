<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\Media;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;


class EcService 
{
    public function getWatchCategories()
    {
        $cacheKey = 'watch_categories';

        // Check if the categories exist in the cache
        if (Redis::exists($cacheKey)) {
            // Retrieve the categories from the cache
            $categories = json_decode(Redis::get($cacheKey));
        } else {
            // Fetch the categories from the database
            $categories = Category::where('parent_id', 2)->withCount('products')->get();
    
            // Store the categories in the cache for future use
            Redis::set($cacheKey, json_encode($categories));
        }
    
        return $categories;
        
    }
   
public function getBagCategories()
{
    $cacheKey = 'bag_categories';

    // Check if the categories exist in the cache
    if (Redis::exists($cacheKey)) {
        // Retrieve the categories from the cache
        $categories = json_decode(Redis::get($cacheKey));
        // dump('edis');
    } else {
        // Fetch the categories from the database
        $categories = Category::where('parent_id', 1)->withCount('products')->get();

        // Store the categories in the cache for future use
        Redis::set($cacheKey, json_encode($categories));
        $expirationTime = 60 * 60; // 1 hour
        // dump('db');
    }

    return $categories;
}
    public function getTop3HotProducts()
    {
        return Product::where('is_hot', 1)->orderBy('created_at', 'DESC')->take(3)->with('thumbnail')->get();
    }
    public function getAllHotProducts()
    {
        return Product::where('is_hot', 1)->with('thumbnail')->get()->paginate(9);
    }

    // public function getListWatches()
    // {
    //     return Product::select('products.*')
    //         ->join('categories', 'products.category_id', '=', 'categories.id')
    //         ->whereIn('products.category_id', function ($query) {
    //             $query->select('id')
    //                 ->from('categories')
    //                 ->whereNotIn('parent_id', [0, 1]);
    //         })
    //         ->with('thumbnail')->paginate(9);
    // }




//get list prd from parent category (bag or watch)
    public function getListPrd($request, $parentCategory)
    {
        if ($parentCategory == 1) {
            $query =  Product::select('products.*')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->whereIn('products.category_id', function ($query) {
                    $query->select('id')
                        ->from('categories')
                        //   ->whereNotIn('parent_id',[0,2]);
                        ->where('parent_id', 1);
                })
                ->with('thumbnail');
        }
        else{
            $query =  Product::select('products.*')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('products.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    
                    ->where('parent_id', 2);
            })
            ->with('thumbnail');
        }
        $priceRanges = [
            '0-300' => [0, 300],
            '300-600' => [300, 600],
            '600+' => [600, null],
        ];

        $prd_count = [];

        foreach ($priceRanges as $key => $range) {
            $countQuery = clone $query; // phải clone vì nếu dùng nguyên query thì sẽ làm thay đổi giá trị của query, ảnh hưởng đến xử lí bên dưới
            if ($range[1]) {
                $countQuery->whereBetween('price', $range);
            } else {
                $countQuery->where('price', '>=', $range[0]);
            }
            $count = $countQuery->count();
            $prd_count[$key] = $count;
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
        if ($request->has('price_range')) {
            $price_range = explode('-', $request->price_range);
            // dd($price_range, count($price_range));
            if ($price_range[1] == '') {
                $query->where('price', '>=', $price_range[0]);
            } else {
                $query->whereBetween('price', [$price_range[0], $price_range[1]]);
            }
        }
        $query->orderBy('created_at', 'DESC');
        //  return $query->paginate(10);
        $result = [
            'products' => $query->paginate(9),
            'prd_count' => $prd_count,
        ];
        return $result;
    }

    public function getListPrdOfChildCategory($category, $request)
    {
        $query = Product::where('category_id', $category)->with('thumbnail');
        $priceRanges = [
            '0-300' => [0, 300],
            '300-600' => [300, 600],
            '600+' => [600, null],
        ];

        $prd_count = [];

        foreach ($priceRanges as $key => $range) {
            $countQuery = clone $query;
            if ($range[1]) {
                $countQuery->whereBetween('price', $range);
            } else {
                $countQuery->where('price', '>=', $range[0]);
            }
            $count = $countQuery->count();
            $prd_count[$key] = $count;
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
        if ($request->has('price_range')) {
            $price_range = explode('-', $request->price_range);

            if ($price_range[1] == '') {
                $query->where('price', '>=', $price_range[0]);
            } else {
                $query->whereBetween('price', [$price_range[0], $price_range[1]]);
            }
        }

        $result = [
            'products' => $query->paginate(9),
            'prd_count' => $prd_count,
        ];
        return $result;
    }



    public function getImages($request)
    {
        $images = Media::where([['mediable_id', $request], ['mediable_type', 'App\Models\Product'], ['type', 'product_image']])->get();
        return $images;
    }

    public function search($keyword)
    {
        $products = Product::where('name', 'like', '%' . $keyword . '%')->with('thumbnail')->paginate(9);
        $countResult = $products->total();


        $result =  [
            'products' => $products,
            'countResult' => $countResult
        ];
        return $result;
    }

    public function getOrderHistory($id)
    {
        $orders= Order::where('customer_id',$id)->with('orderDetails')->paginate(9);
        // dd($orders);
        return $orders; 
    }
}
