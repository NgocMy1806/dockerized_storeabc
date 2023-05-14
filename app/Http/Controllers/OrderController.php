<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Services\ProductService;


class OrderController extends Controller
{
    private $productService;
    private $orderService;

    public function __construct(ProductService $productService, OrderService $orderService)
    {
        $this->productService = $productService;
        $this->orderService = $orderService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderService->getOrders();
        // dd($orders);
        return view('admin.order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderService->getOrderDetail($id);
        $orderDetails = $order->orderDetails; // change to orderDetails

        // foreach ($order_details as $order_detail) {
        //     $product = $order_detail->product;
        //     dd($product);
        return view('admin.order.view', ['order' => $order, 'orderDetails' => $orderDetails]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            if ($request->payment_status) {
                $payment_status = $request->payment_status == 'paid' ? 'paid' : 'unpaid';
                $this->orderService->changePaymentStatus($id, $payment_status);
                return response()->json([
                    'success' => "Payment status updated successfully.",
                ]);
            }
            if ($request->order_status) {
                $order_status = $request->order_status;
                $this->orderService->changeOrderStatus($id, $order_status);
                return response()->json([
                    'success' => "Order status updated successfully.",
                ]);
            }
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
        //
    }
}
