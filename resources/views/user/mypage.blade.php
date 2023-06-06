@extends('user.layout.layout')
@section('content')
    <div class="container">
        <div class="card">
            <!-- Section 1: User Information -->
            <div class="user-info card-header">
                <h2>User Information</h2>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Address:</strong>{{ $user->country->country_name }} - {{ $user->state->state_name }} -
                    {{ $user->city->city_name }} - {{ $user->address_bottom }}</p>
            </div>
        </div>
        <hr>
            <!-- Section 2: Order History -->
            <div class="order-history"></div>
                <h2>Order History</h2>
                @if ($orders->isEmpty())
            <div>You don't have any orders on Waba </div>
            @else
                @foreach ($orders as $order)
                    <div class="order">
                        <h4><strong>Order ID: </strong>{{ $order->id }}</h4>
                        <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p>
                        <p><strong>Order Status:</strong> {{ $order->order_status }}</p>
                        <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                        <p><strong>List product:</strong> </p>
                        <ul class="product-list">
                            @foreach ($order->orderDetails as $item)
                            <li><img width="50" height="50"
                                class="img-thumbnail"src="{{ asset('storage/thumbnail/' . $item->product->thumbnail->name) }}">  {{ $item->product->name }}: ({{ $item->quantity }} x {{ $item->price }})</li>
                        @endforeach
                        </ul>
                    </div>
                    <p>----------------------------------------------</p>
                @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

