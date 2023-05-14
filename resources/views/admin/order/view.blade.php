@extends('admin.layout.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Order detail</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Total amount</th>
                                    <td>$ {{ $order->total_amount }}</td>
                                </tr>
                                <tr>
                                    <th>Order status</th>
                                    <td>{{ $order->order_status }}</td>
                                </tr>
                                <tr>
                                    <th>Payment status</th>
                                    <td>{{ $order->payment_status }}</td>
                                </tr>
                                <tr>
                                    <th>Payment method</th>
                                    <td>{{ $order->payment_method }}</td>
                                </tr>
                                <tr>
                                    <th>Customer name</th>
                                    <td>{{ $order->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Customer email</th>
                                    <td>{{ $order->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping address</th>
                                    <td>{{ $order->country->country_name }} - {{ $order->state->state_name }} -
                                        {{ $order->city->city_name }} - {{ $order->address_bottom }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">List products in this order</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderDetails as $item)
                                            <tr>
                                                <td><img width="50" height="50"
                                                        class="img-thumbnail"src="{{ asset('storage/thumbnail/' . $item->product->thumbnail->name) }}">
                                                </td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price * $item->quantity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
    </div>
@endsection
