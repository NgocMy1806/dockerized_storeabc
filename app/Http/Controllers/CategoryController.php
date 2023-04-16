<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $categories=$this->categoryService->getAllCategory();

        return view ('admin.category.index', ['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $parentCategories=$this->categoryService->getParentCategories();
    //   var_dump($parentCategories);die;
        return view('admin.category.create',['parentCategories'=>$parentCategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category= $this->categoryService->store($request);
        
        return redirect ()->route('categories.index')->with ('success', 'create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parentCategories=$this->categoryService->getParentCategories();
        $category=$this->categoryService->getCategoryDetail($id);
    //    dd($category->id);
        return view('admin.category.create',['parentCategories'=>$parentCategories,'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        if($request->ajax()){
           
            $this->categoryService->changeStatus($id,$request);

            return response()->json([
                'success'=>"change status OK",
            ]);
        }
        // dd($request->name);
        $category=$this->categoryService->update($request,$id);
        
        return redirect ()->route('categories.index')->with ('success', 'edit successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
         $category = $this->categoryService->destroy($id);
      
        return redirect()->route('categories.index')->with('success', 'Category has been deleted');
    
    }
   
}
