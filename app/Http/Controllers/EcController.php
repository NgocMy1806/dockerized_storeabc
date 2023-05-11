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
        $result = $this->ecService->getListBags($request);
        $products = $result['products'];
        $bags_count = $result['bags_count'];
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
                    'bags_count' => $bags_count,
                   
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
                'bags_count' => $bags_count
            ]
        );
    }


    public function getListBagsOfChildCategory($category, Request $request)
    {
        // dd($request->all());
        $result = $this->ecService->getListPrdOfChildCategory($category, $request);
        $products = $result['products'];
        $bags_count = $result['bags_count'];
        $active_category_id=$category;
        if ($request->ajax()) {
            return view(
                'user.listPrdByCateAjax',
                [
                    'watchCategories' => $this->watchCategories,
                    'bagCategories' => $this->bagCategories,
                    'products' => $products,
                    'sort_key' => $request->sort_key,
                    'price_range' => $request->price_range,
                    'bags_count' => $bags_count,
                    'active_category_id' => $active_category_id, // Pass the active category ID to the view
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
                'bags_count' => $bags_count
            ]
        );
    }

    public function getListWatches()
    {
        $products = $this->ecService->getListWatches();

        return view(
            'user.listwatches',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products
            ]
        );
    }

    //this function use to get list watch of child category
    public function getListWatchesOfChildCategory($category, Request $request)
    {
        // dd($request->all());
        $products = $this->ecService->getListPrdOfChildCategory($category, $request);

        if ($request->ajax()) {
            return view(
                'user.listPrdByCateAjax',
                [
                    'watchCategories' => $this->watchCategories,
                    'bagCategories' => $this->bagCategories,
                    'products' => $products
                ]
            )->render();
        }
        return view(
            'user.listwatches',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products
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
}
