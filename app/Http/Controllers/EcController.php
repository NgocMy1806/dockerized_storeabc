<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\EcService;
use App\Enums\sortTypeEnum;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

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
        //  dd(bcrypt('12345678'));
        $hotProducts = $this->ecService->getTop3HotProducts();
        $cart = session()->get('cart');
        $total = session()->get('total');


        return view(
            'user.index',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'hotProducts' => $hotProducts
            ]
        );
    }

    public function getListBags(Request $request)
    {
        $parentCategory=1;
        $result = $this->ecService->getListPrd($request,$parentCategory);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        // $products = $this->ecService->getListBags($request);
        if ($request->ajax()) {
            return view(
                'user.listPrdByCateAjax',
                [
                    'watchCategories' => $this->watchCategories,
                    'bagCategories' => $this->bagCategories,
                    'products' => $products,
                    'sort_key' => $request->sort_key,
                    'price_range' => $request->price_range,
                    'prd_count' => $prd_count,
                   
                ]
            )->render();
        }
        return view(
            'user.listbags',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'sort_key' => $request->sort_key ? $request->sort_key : null,
                'price_range' => $request->price_range ? $request->price_range : null,
                'prd_count' => $prd_count,
                'parentCategory' =>$parentCategory
            ]
        );
    }

    public function getListBagsOfChildCategory($category, Request $request)
    {
        $result = $this->ecService->getListPrdOfChildCategory($category, $request);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        $active_category_id = $category;
    
        if ($request->ajax()) {
            return view('user.listPrdByCateAjax', [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'sort_key' => $request->sort_key,
                'price_range' => $request->price_range,
                'prd_count' => $prd_count,
                'active_category_id' => $active_category_id, 
            ])->render();
        }
    
        return view('user.listbags', [
            'watchCategories' => $this->watchCategories,
            'bagCategories' => $this->bagCategories,
            'products' => $products,
            'sort_key' => $request->sort_key ? $request->sort_key : null,
            'price_range' => $request->price_range ? $request->price_range : null,
            'prd_count' => $prd_count,
            'active_category_id' => $active_category_id, 
        ]);
    }
    

    public function getListWatches(Request $request)
    {
        $parentCategory=2;
        $result = $this->ecService->getListPrd($request, $parentCategory);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        // $products = $this->ecService->getListBags($request);
        if ($request->ajax()) {
            return view(
                'user.listPrdByCateAjax',
                [
                    'watchCategories' => $this->watchCategories,
                    'bagCategories' => $this->bagCategories,
                    'products' => $products,
                    'sort_key' => $request->sort_key,
                    'price_range' => $request->price_range,
                    'prd_count' => $prd_count,
                    
                ]
            )->render();
        }
        return view(
            'user.listwatches',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'sort_key' => $request->sort_key ? $request->sort_key : null,
                'price_range' => $request->price_range ? $request->price_range : null,
                'prd_count' => $prd_count
            ]
        );
    }

    //this function use to get list watch of child category
    public function getListWatchesOfChildCategory($category, Request $request)
    {
        $result = $this->ecService->getListPrdOfChildCategory($category, $request);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        $active_category_id = $category;
    
        if ($request->ajax()) {
            return view('user.listPrdByCateAjax', [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'sort_key' => $request->sort_key,
                'price_range' => $request->price_range,
                'prd_count' => $prd_count,
                'active_category_id' => $active_category_id, 
            ])->render();
        }
    
        return view('user.listwatches', [
            'watchCategories' => $this->watchCategories,
            'bagCategories' => $this->bagCategories,
            'products' => $products,
            'sort_key' => $request->sort_key ? $request->sort_key : null,
            'price_range' => $request->price_range ? $request->price_range : null,
            'prd_count' => $prd_count,
            'active_category_id' => $active_category_id, 
        ]);
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
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('thumbnail')->find($id);

        $thumbnail = $product->thumbnail()->first()->name;
        if (!$product) {
            abort(404);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
            // $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'thumbnail' => $thumbnail
            ];
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('total', $total);

        return response()->json([
            'success' => 'Product added to cart successfully!',
            'cart' => $cart,
            'total' => $total,
            'cartCount' => count(session('cart')),
        ]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $e = array_sum(array_column($cart, 'quantity'));

        return view(
            'user.cart',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'cart' => $cart,
                'total' =>  $total
            ]
        );
    }
    public function EmptyCart()
    {

        session()->forget('cart');
        session()->forget('total');
        return redirect()->back()->with('success', 'Cart emptied successfully!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $quantity = 0;

        if (isset($cart[$id])) {
            $quantity = $cart[$id]['quantity'];
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $quantity += $item['quantity'];
        }

        session()->put('total', $total);
        session()->put('quantity', $quantity);

        // return redirect()->back()->with('success', 'Product removed from cart successfully!');
        return redirect()->route('showCart')->with('success', 'Product removed from cart successfully!');
    }

    public function getCheckout()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $countries = Country::all();
        //dd($countries);
        return view(
            'user.checkout',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'cart' => $cart,
                'total' =>  $total,
                'countries' => $countries,

            ]
        );
    }
    public function getStates($id)
    {
        $states = State::where('country_id', $id)->get();
        return response()->json(['states' => $states]);
    }
    public function getCities($id)
    {
        $cities = City::where('state_id', $id)->get();
        return response()->json(['cities' => $cities]);
    }

    public function search (Request $request)
    {
        // dd('hi');
        $result=$this->ecService->search($request->keyword);
        $products = $result['products'];
        $countResult = $result['countResult'];
        return view('user.searchResult',
        [
            'watchCategories' => $this->watchCategories,
            'bagCategories' => $this->bagCategories,
            'products' => $products,
            'keyword' => $request->keyword,
            'countResult' => $countResult
        ]);
    }

}
