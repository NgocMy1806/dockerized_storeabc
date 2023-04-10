<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\EcService;
use App\Enums\sortTypeEnum;
use App\Models\Product;

class EcController extends Controller
{
    private $productService;
    private $categoryService;
    private $ecService;
    public $watchCategories;
    public $bagCategories;
    public function __construct(ProductService $productService, CategoryService $categoryService, EcService $ecService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->ecService = $ecService;
        $this->watchCategories = $this->ecService->getWatchCategories();
        $this->bagCategories = $this->ecService->getBagCategories();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotProducts = $this->ecService->getTop3HotProducts();
// dd($this->watchCategories);
        return view(
            'user.index',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'hotProducts' => $hotProducts
            ]
        );
    }

    public function getListBags()
    {
        $listBags = $this->ecService->getListBags();
        // $count=$this->ecService->countBags();
        return view(
            'user.listbags',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'listBags' => $listBags
            ]
        );
    }

    public function getListBagsOfChildCategory($category)
    {
        $listChildBags = $this->ecService->getListBagsOfChildCategory($category);
        return view(
            'user.listbags',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'listChildBags' => $listChildBags
            ]
        );
    }

    public function getDetailPrd($id)
    {
        $product = Product::where('id', $id)->with(['tags', 'thumbnail'])->first();
        $images = $this->productService->getImages($id);

        return view(
            'user.detailPrd',
            [
                'product' => $product,
                'images' => $images,
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
            ]
        );
    }
}
