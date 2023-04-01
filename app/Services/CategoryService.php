<?php

namespace App\Services;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService extends BaseService
{
    public function getAllCategory()
    {
        // return Category::paginate(10);
       
        //cach 1: dùng with là eager load khi đang build câu query , chỉ dùng with thì mới phân trang được
        return Category::with(['parentCategory'])->paginate(10);

        //cach 2: dùng load là sau khi lấy data colection ra xong mình mới load thêm quan hệ
         // return Category::paginate(10)->load(['parentCategory']);


    }
    public function getParentCategories()
    {
        return Category::where('parent_id',0 )->get();
    }
    public function store($request){
        $category = Category::create([
            'name'  => $request->name ?? 'asc',
            'slug' => Str::slug($request->name ?? 'asc'),
            'status' => $request->status?1:0,
            'parent_id' => $request->parent_id??0,
        ]);
      
        return $category;
    }

    public function getCategoryDetail($request){
        return Category::where('id',$request )->first();
    }

    public function update($request,$id){
    // dd ($id);
        Category::find($id)
        ->update([
            'name' => $request->name??null,
            'slug' => Str::slug($request->name),
            'status' => $request->status?1:0,
            'parent_id' => $request->parent_id??0,
        ]);

    }
    public function destroy ($id) {
       return Category::withTrashed()
        ->where('id', $id)
        ->get();
    } 

    public function changeStatus($id, $request){
       $category= Category::find($id);
       $category->update([
        'status'=>$request->status?1:0,
       ]);
       return true;
    }
    // public function destroy($id)
    // {
    //     $category = $this->categoryService->getCategory($id);
    //     $category->delete();

    //     return redirect()->route('categories.index')->with('success', 'Delete Category Successfully!');
    // }

    public function getChildCategories(){
        return Category::where('parent_id','<>',0)->get();
    }

}