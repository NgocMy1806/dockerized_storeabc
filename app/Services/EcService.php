<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EcService extends BaseService
{
    public function getWatchCategories(){
        return Category::where('parent_id',8)->get();
    }
    public function getBagCategories(){
        return Category::where('parent_id',9)->withCount('products')->get();
    }
    public function getTop3HotProducts(){
        return Product::where('is_hot',1)->take(3)->with('thumbnail')->get();
    }
    public function getAllHotProducts(){
        return Product::where('is_hot',1)->with('thumbnail')->get()->paginate(9);
    }

    public function getListWatches(){
        return Product::select('products.*')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->whereIn('products.category_id', function ($query) {
            $query->select('id')
                  ->from('categories')
                  ->whereNotIn('parent_id',[0,9]);
        })
        ->with('thumbnail')->paginate(9);

    }

    public function getListWatchesOfChildCategory($category){

    }

   

    public function getListBags(){
        return Product::select('products.*')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->whereIn('products.category_id', function ($query) {
            $query->select('id')
                  ->from('categories')
                  ->whereNotIn('parent_id',[0,8]);
        })
        ->with('thumbnail')->paginate(9);

    }

    public function getListPrdOfChildCategory($category){
        return Product::where('category_id',$category)->with('thumbnail')->paginate(9);
    }

    public function countBags($category){
        $count = Product::where('category_id', $category)->count();
        return $count;
    }

    public function getImages($request)
    {
        $images = Media::where([['mediable_id', $request], ['mediable_type', 'App\Models\Product'], ['type', 'product_image']])->get();
        return $images;
    }
}