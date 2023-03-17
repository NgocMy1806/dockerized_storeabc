<?php

namespace App\Services;
use App\Models\Category;

class CategoryService extends BaseService
{
    public function getAllCategory()
    {
        return Category::paginate(10);
    }
    public function getParentCategories()
    {
        return Category::where('parent_id',0 )->get();
    }
    public function store($request){
        Category::create([
            'name' => $request->name??null,
            'slug' => $request->slug??null,
            'status' => $request->status?1:0,
            'parent_id' => $request->parent_id??0,
        ]);
    }

    public function getCategoryDetail($request){
        return Category::where('id',$request )->first();;
    }
}