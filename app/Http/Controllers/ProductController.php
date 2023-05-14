<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;
use App\Models\Product;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Enums\sortTypeEnum;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $childrenCate = $this->categoryService->getChildCategories();
        $products = $this->productService->getProducts($request);

        return view(
            'admin.products.index',
            [
                'products' => $products,
                'childrenCat' => $childrenCate,
                'catSelected' => $request->cat_filter,
                'textSearch' => $request->text_search,
                'sortKey' => $request->sort_key,
                'sortType' => SortTypeEnum::getSortType(),
            ]
        );
    }
    // $childCategories=$this->categoryService->getChildCategories();
    // $products=$this->productService->getProducts($request);
    // dd(!$products->isEmpty());


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(bcrypt(12345678));
        $childCategories = $this->categoryService->getChildCategories();
        return view('admin.products.create', ['childCategories' => $childCategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());

        $this->productService->store($request);
        return redirect()->route('products.index')->with('success', 'create successfully');
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
        $product=Product::where('id',$id)->with(['tags','thumbnail',])->first();
        $childCategories = $this->categoryService->getChildCategories();
        // $product = $this->productService->getProductDetail($id);
        
        //ko cần lấy riêng thumbnail, dùng with để get ra quan hệ là được r
        //$thumbnail = $this->productService->getThumbnail($id);

         $images = $this->productService->getImages($id);

        
        return view(
            'admin.products.edit',
            [
                 'childCategories' => $childCategories,
                'product' => $product,
                // 'thumbnail' => $thumbnail,
                'images' => $images
            ]
        );
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
        //   dd($request->hasFile('thumbnail'));
        
        $product = $this->productService->update($id,$request);
        // if($request->ajax()){
           
        //     $this->productService->changeStatus($id,$request);

        //     return response()->json([
        //         'success'=>"change status OK",
        //     ]);
        // }

        return redirect()->route('products.index')->with('success', 'edit successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->productService->delete($id);

        if (!$delete) {
            return redirect()->route('products.index')->with('success', 'Delete Product Fail!');
        }

        return redirect()->route('products.index')->with('success', 'Delete Product Successfully!');
    }
}
