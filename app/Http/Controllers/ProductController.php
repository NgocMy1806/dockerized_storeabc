<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;
use App\Models\Product;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Enums\sortTypeEnum;
use App\Models\Tag;

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
        $tags = Tag::all();
        $childCategories = $this->categoryService->getChildCategories();
        return view(
            'admin.products.create',
            [
                'childCategories' => $childCategories,
                'tags' => $tags,
            ]
        );
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
        $product = Product::where('id', $id)->with(['tags', 'thumbnail', 'images'])->first();
        $childCategories = $this->categoryService->getChildCategories();
        // $product = $this->productService->getProductDetail($id);

        //ko cần lấy riêng thumbnail, images, dùng with để get ra quan hệ là được r
        //$thumbnail = $this->productService->getThumbnail($id);
        //  $images = $this->productService->getImages($id);
        $images = $product->images;

        $tags = Tag::all();
        return view(
            'admin.products.edit',
            [
                'childCategories' => $childCategories,
                'product' => $product,
                // 'thumbnail' => $thumbnail,
                'images' => $images,
                'tags' => $tags,
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

        if ($request->ajax()) {
            if ($request->is_hot) {

                $is_hot = $request->is_hot == '1' ? '1' : '0';
                // dd($is_hot);
                $this->productService->changeHotStatus($id, $is_hot);
                return response()->json([
                    'success' => "Is_hot status updated successfully.",
                ]);
            }
            if ($request->is_active) {
                $is_active = $request->is_active;
                $this->productService->changeActiveStatus($id, $is_active);
                return response()->json([
                    'success' => "Active status updated successfully.",
                ]);
            }
        } else {
            $product = $this->productService->update($id, $request);
            return redirect()->route('products.index')->with('success', 'edit successfully');
        }
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
