@extends('user.layout.layout')
@section('content')
    <div class="container">
        <div class="card">
            <!-- Section 1: User Information -->
            <div class="user-info">
                <h2>User Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Address:</strong>{{ $user->country->country_name }} - {{ $user->state->state_name }} -
                    {{ $user->city->city_name }} - {{ $user->address_bottom }}</p>
            </div>

            <!-- Section 2: Order History -->
            <div class="order-history"></div>
                <h2>Order History</h2>
                @if ($orders->isEmpty())
            <div>You don't have any orders on Waba </div>
            @else
                @foreach ($orders as $order)
                    <div class="order">
                        <h3>Order ID: {{ $order->id }}</h3>
                        <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p>
                        <p><strong>Order Status:</strong> {{ $order->order_status }}</p>
                        <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                        <ul class="product-list">
                            @foreach ($order->orderDetails as $orderDetail)
                            <li>{{ $orderDetail->product->name }}: ({{ $orderDetail->quantity }} x {{ $orderDetail->price }})</li>
                        @endforeach
                        
                        </ul>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

