@extends('user.layout.layout')
@section('content')
    <div class="container">
        <div class="card">
            <!-- Section 1: User Information -->
            <div class="user-info">
                <h2>User Information</h2>
                <p><strong>Name:</strong> {{ session()->get('userName') }}</p>
                <p><strong>Email:</strong> {{ session()->get('userEmail') }}</p>
                <p><strong>Address:</strong> {{ session()->get('userAddress') }}</p>
            </div>

            <!-- Section 2: Order History -->
            {{$orders}}
            < class="order-history">
                <h2>Order History</h2>
                @if ($orders->isEmpty())
            <div>You don't have any orders on waba </div>
            @else
                @foreach ($orders as $order)
                    <div class="order">
                        <h3>Order ID: {{ $order->id }}</h3>
                        <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p>
                        <p><strong>Order Status:</strong> {{ $order->status }}</p>
                        <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                        <ul class="product-list">
                            @foreach ($order->orderDetails as $orderDetail)
                            <li>{{ $orderDetail->product->name }} ({{ $orderDetail->quantity }} x {{ $orderDetail->price }})</li>
                        @endforeach
                        
                        </ul>
                    </div>
                @endforeach
                @endif
            </div>




        </div>
    </div>
@endsection

