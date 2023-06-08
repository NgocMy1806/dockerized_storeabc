@extends('user.layout.layout')
@section('content')
    <div class="account-in">
        <div class="container">
            <div class="check_box">
                <div class="col-md-9 cart-items">
                    {{-- <h1>My Shopping Bag ({{count($cart)}})</h1> --}}
                    <h1>My Shopping Bag ({{ session()->get('totalQuantity') }} items)</h1>

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
                                        <img src="{{ $item['thumbnail'] }}"class="img-responsive"
                                            alt="" />
                                    </div>
                                    <div class="cart-item-info">
                                        <h3><a href="{{ route('detailPrd', $item['id']) }}">{{ $item['name'] }}</a></span>
                                        </h3>
                                        <ul class="qty">
                                            <li>
                                                <p>Size : 5</p>
                                            </li>
                                            <li>
                                                <span>Quantity:</span>
                                                <select class="quantity-select" data-product-id="{{  $item['id'] }}">
                                                    <option value="1" {{ $item['quantity'] == 1 ? 'selected' : '' }}>1
                                                    </option>
                                                    <option value="2" {{ $item['quantity'] == 2 ? 'selected' : '' }}>2
                                                    </option>
                                                    <option value="3" {{ $item['quantity'] == 3 ? 'selected' : '' }}>3
                                                    </option>
                                                    <option value="4" {{ $item['quantity'] == 4 ? 'selected' : '' }}>4
                                                    </option>
                                                    <option value="5" {{ $item['quantity'] == 5 ? 'selected' : '' }}>5
                                                    </option>
                                                    <option value="6" {{ $item['quantity'] == 6 ? 'selected' : '' }}>6
                                                    </option>
                                                </select>
                                            </li>
                                        </ul>
                                        <div class="delivery">
                                            <p>Service Charges for 1 item : $ {{ $item['price'] }}</p>
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
                    <a class="continue" href="{{ route('index') }}">Continue to browser product</a>
                    <div class="price-details">
                        <h3>Price Details</h3>
                        <span>Total</span>
                        <span class="total1" id="total1">$ {{session()->get('total')}}</span>
                        <span>Discount</span>
                        <span class="total1">---</span>
                        <span>Delivery Charges</span>
                        <span class="total1" id="shipping_fee">$ {{$shipping_fee}}</span>
                        <div class="clearfix"></div>
                    </div>
                    <ul class="total_price">
                        <li class="last_price" >
                            <h4>TOTAL</h4>
                        </li>
                        <li class="last_price">
                            <span id="last_price">$ {{session()->get('total')+ $shipping_fee }}</span>
                        </li>
                        <div class="clearfix"> </div>
                    </ul>
                    <div class="clearfix"></div>
                    <a class="order" href="{{ route('checkout') }}">Place Order</a>
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
    <script>
       $(document).ready(function() {
    $('.quantity-select').change(function(event) {
        event.preventDefault();

        var productId = $(this).data('product-id');
        var quantity = $(this).val();
       
        var url = "{{ route('changeQty', ':productId') }}".replace(':productId', productId);
        console.log(productId);
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'JSON',
            data: {
                _token: '{{ csrf_token() }}',
                id: productId,
                quantity: quantity
            },
            success: function(response) {
                $('.quantity-select[data-product-id="' + productId + '"]').val(response.cart[productId].quantity);
                //update value in header
                $('#cart-total').html('$' + response.total.toFixed(2));
                $('#cart-count').text(response.totalQuantity);

                //update value in Price detail in the right side of cart screen
                $('#total1').text('$' + response.total.toFixed(2));
                $('#last_price').text('$' + response.total.toFixed(2) + response.shipping_fee);

                alert('Changed quantity successfully!');
            },
            error: function(response) {
                console.log(response);
                alert('Error occurred while changing quantity. Please try again!');
            }
        });
    });
});

    </script>
@endpush
