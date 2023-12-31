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
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;



class EcController extends Controller
{
    private $productService;
    private $categoryService;
    public $ecService;
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
        //dd(getenv('APP_ENV'));
        if (getenv('APP_ENV')!== 'local') {
            $instanceId = file_get_contents('http://169.254.169.254/latest/meta-data/instance-id');
        } else {
            $instanceId = null;
        }

        return view(
            'user.index',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'hotProducts' => $hotProducts,
                'instanceId' => $instanceId
            ]
        );
    }

    public function getListBags(Request $request)
    {

        $parentCategory = 1;
        $result = $this->ecService->getListPrd($request, $parentCategory);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        $products_count = $result['products_count'];
        // dd($products_count);
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
                    'products_count' => $products_count
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
                'parentCategory' => $parentCategory,
                'products_count' => $products_count
            ]
        );
    }

    public function getListBagsOfChildCategory($category, Request $request)
    {
        $result = $this->ecService->getListPrdOfChildCategory($category, $request);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        $active_category_id = $category;
        $products_count = $result['products_count'];
        if ($request->ajax()) {
            return view('user.listPrdByCateAjax', [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'sort_key' => $request->sort_key,
                'price_range' => $request->price_range,
                'prd_count' => $prd_count,
                'active_category_id' => $active_category_id,
                'products_count' => $products_count
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
            'products_count' => $products_count
        ]);
    }


    public function getListWatches(Request $request)
    {
        $parentCategory = 2;
        $result = $this->ecService->getListPrd($request, $parentCategory);
        $products = $result['products'];
        $prd_count = $result['prd_count'];
        $products_count = $result['products_count'];
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
                    'products_count' => $products_count
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
                'prd_count' => $prd_count,
                'products_count' => $products_count
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
        $products_count = $result['products_count'];
        if ($request->ajax()) {
            return view('user.listPrdByCateAjax', [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'sort_key' => $request->sort_key,
                'price_range' => $request->price_range,
                'prd_count' => $prd_count,
                'active_category_id' => $active_category_id,
                'products_count' => $products_count
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
            'products_count' => $products_count
        ]);
    }
    public function getDetailPrd($id)
    {
        $product = Product::where('id', $id)->with(['tags', 'thumbnail', 'images'])->first();
        $images = $product->images;
        $relatedProducts = Product::whereHas('tags', function ($query) use ($product) {
            $query->whereIn('tags.id', $product->tags->pluck('id'));
        })
            ->where('products.id', '!=', $id)
            ->with(['tags', 'thumbnail'])
            ->orderBy('products.created_at', 'DESC')
            ->limit(4)
            ->get();

        return view(
            'user.detailPrd',
            [
                'product' => $product,
                'images' => $images,
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'relatedProducts' => $relatedProducts
            ]
        );
    }
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('thumbnail')->find($id);

        // $thumbnail = $product->thumbnail()->first()->name;
        $thumbnail = $product->thumbnail->url;
        if (!$product) {
            abort(404);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'thumbnail' => $thumbnail
            ];
        }
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        // total amount
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('total', $total);
        session()->put('totalQuantity', $totalQuantity);

        return response()->json([
            'success' => 'Product added to cart successfully!',
            'cart' => $cart,
            'total' => $total,
            'totalQuantity' => $totalQuantity,
            // 'cartCount' => count(session('cart')), show number of distinct prd in cart

        ]);
    }

    public function showCart()
    {
        // dd(session()->all());
        $cart = session()->get('cart', []);
        //     dd(session()->all());
        // dd(session('totalQuantity'));

        // $total = 0;
        // foreach ($cart as $item) {
        //     $total += $item['price'] * $item['quantity'];
        // }
        // $totalQuantity = array_sum(array_column($cart, 'quantity'));

        $shipping_fee = 0.00;
        return view(
            'user.cart',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'cart' => $cart,
                'shipping_fee' => $shipping_fee,
                // 'total' =>  $total,
                // 'totalQuantity' => $totalQuantity,
            ]
        );
    }
    public function EmptyCart()
    {

        session()->forget('cart');
        session()->forget('total');
        session()->forget('totalQuantity');
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

    public function changeQty(Request $request)
    {
        $cart = session()->get('cart', []);
        $shipping_fee = 0.00;
        $total = 0;
        $totalQuantity = 0;
        $cart[$request->id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $totalQuantity += $item['quantity'];
        }
        session()->put('total', $total);
        session()->put('totalQuantity', $totalQuantity);

        return response()->json([
            'success' => 'Changed quantity successfully!',
            'cart' => $cart,
            'total' => $total,
            'totalQuantity' => $totalQuantity,
            'shipping_fee' => $shipping_fee,
        ]);
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
        $user = null;
        if (session()->has('userId')) {
            $id = session()->get('userId');
            $user = Customer::with('country', 'state', 'city')->find($id);
        }

        return view(
            'user.checkout',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'cart' => $cart,
                'total' =>  $total,
                'countries' => $countries,
                'user' => $user
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

    public function search(Request $request)
    {
        // dd('hi');
        $result = $this->ecService->search($request->keyword);
        $products = $result['products'];
        $countResult = $result['countResult'];
        return view(
            'user.searchResult',
            [
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
                'products' => $products,
                'keyword' => $request->keyword,
                'countResult' => $countResult
            ]
        );
    }

    public function getMypage($id)
    {
        // $userName = session()->get('userName');
        $user = Customer::with('country', 'state', 'city')->find($id);

        $orders = $this->ecService->getOrderHistory($id);
        // dd($orders);
        return view(
            'user.mypage',
            [
                // 'userName'=>$userName,
                'orders' =>  $orders,
                'user' => $user,
                'watchCategories' => $this->watchCategories,
                'bagCategories' => $this->bagCategories,
            ]
        );
    }
}
