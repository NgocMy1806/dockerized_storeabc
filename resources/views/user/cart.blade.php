@extends('user.layout.layout')
@section('content')
    <div class="account-in">
        <div class="container">
            <div class="check_box">
                <div class="col-md-9 cart-items">
                    <h1>My Shopping Bag ({{count($cart)}})</h1>
                    <script>
                        $(document).ready(function(c) {
                            $('.close1').on('click', function(c) {
                                $('.cart-header').fadeOut('slow', function(c) {
                                    $('.cart-header').remove();
                                });
                            });
                        });
                    </script>
                    @if (count($cart) > 0)
                        @foreach ($cart as $item)
                            <div class="cart-header">
                                <div class="close1">
                                    <form action="{{ route('removeFromCart', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"><i class="fa-solid fa-square-xmark"></i></button>
                                    </form>
                                </div>
                                <div class="cart-sec simpleCart_shelfItem">
                                    <div class="cart-item cyc">
                                        <img src="{{ asset('storage/thumbnail/' . $item['thumbnail']) }}"class="img-responsive"
                                            alt="" />
                                    </div>
                                    <div class="cart-item-info">
                                        <h3><a href="{{ route('detailPrd',$item['id'])}}">{{ $item['name'] }}</a></span></h3>
                                        <ul class="qty">
                                            <li>
                                                <p>Size : 5</p>
                                            </li>
                                            <li>
                                                <p>Quantity :{{ $item['quantity'] }}</p>
                                            </li>
                                        </ul>
                                        <div class="delivery">
                                            <p>Service Charges : $ {{ $item['price'] }}</p>
                                            <span>Delivered in 2-3 business days</span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        @endforeach
                   
                    <script>
                        $(document).ready(function(c) {
                            $('.close2').on('click', function(c) {
                                $('.cart-header2').fadeOut('slow', function(c) {
                                    $('.cart-header2').remove();
                                });
                            });
                        });
                    </script>

                </div>
                <div class="col-md-3 cart-total">
                    <a class="continue" href="{{route('index')}}">Continue to browser product</a>
                    <div class="price-details">
                        <h3>Price Details</h3>
                        <span>Total</span>
                        <span class="total1">6200.00</span>
                        <span>Discount</span>
                        <span class="total1">---</span>
                        <span>Delivery Charges</span>
                        <span class="total1">150.00</span>
                        <div class="clearfix"></div>
                    </div>
                    <ul class="total_price">
                        <li class="last_price">
                            <h4>TOTAL</h4>
                        </li>
                        <li class="last_price"><span>6350.00</span></li>
                        <div class="clearfix"> </div>
                    </ul>
                    <div class="clearfix"></div>
                    <a class="order" href="{{route('checkout')}}">Place Order</a>
                    <div class="total-item">
                        <h3>OPTIONS</h3>
                        <h4>COUPONS</h4>
                        <a class="cpns" href="#">Apply Coupons</a>
                        <p><a href="#">Log In</a> to use accounts - linked coupons</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                @else
                <h2> You haven't choose any product </h2>
            @endif
            </div>
        </div>
    </div>
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3150859.767904157!2d-96.62081048651531!3d39.536794757966845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1408111832978">
        </iframe>
    </div>
@endsection
@push('custom-js')
@endpush
