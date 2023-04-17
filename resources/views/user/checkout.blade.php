@extends('user.layout.layout')
@section('content')
<script src="https://js.stripe.com/v3/"></script>
<div class="container">
  <h1>Shopping Cart</h1>
  @if (Session::has('cart'))
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
        @foreach ($cart as $item)
          <tr>
            <td><img width="50" height="50"
              class="img-thumbnail"src="{{ asset('storage/thumbnail/' .  $item['thumbnail']) }}"></td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['price'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['price'] * $item['quantity'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p>Your cart is empty</p>
  @endif
  <form method="POST" action="{{ route('checkout') }}">
    @csrf
    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit"class="btn btn-primary" id="checkout-button">Checkout</button>
  </form>
</section>
@endsection