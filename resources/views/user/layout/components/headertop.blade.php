<div class="header_top">
    <div class="header_top_left">
        <div class="box_11"><a href="{{ route('showCart') }}">
                <h4>
                    {{-- <p>Cart: <span class="" style="margin-top:6px;color:black;">${{ session('total', '0.00') }}
                        </span>
                        (<span>
                            {{ session()->has('cart') && count(session('cart')) > 0 ? count(session('cart')) : 0 }}
                        </span> items)</p> --}}
                        <p>Cart: <span id="cart-total" style="margin-top:6px;color:black;">${{ session('total', '0.00') }}
                        </span> (<span id="cart-count">{{ session()->has('cart') && count(session('cart')) > 0 ? count(session('cart')) : 0 }}</span> items)</p>
                    
                    <img src="{{ asset('user/images/bag.png') }}" alt="" />
                    <div class="clearfix"> </div>
                </h4>
            </a></div>

        {{-- <p class="empty"><a href="#"class=" custom-empty-cart">Empty Cart</a></p> --}}
        @if (count(session('cart', [])) > 0)
    <form action="{{ route('EmptyCart') }}" method="POST">
      @method('delete')
        @csrf
        <button type="submit" style="float: right">Empty Cart</button>
    </form>
@endif
        <div class="clearfix"> </div>
    </div>
    <div class="header_top_right">
        <ul class="header_user_info">
            <a class="login" href="login.html">
                <i class="user"> </i>
                <li class="user_desc">My Account</li>
            </a>
            <div class="clearfix"> </div>
        </ul>
        <!-- start search-->
        <div class="search-box">
            <div id="sb-search" class="sb-search">
                <form>
                    <input class="sb-search-input" placeholder="Enter your search term..." type="search" name="search"
                        id="search">
                    <input class="sb-search-submit" type="submit" value="">
                    <span class="sb-icon-search"> </span>
                </form>
            </div>
        </div>
        <!----search-scripts---->
        <script src="{{ asset('user/js/classie1.js') }}"></script>
        <script src="{{ asset('user/js/uisearch.js') }}"></script>
        <script>
            new UISearch(document.getElementById('sb-search'));
        </script>
        <!----//search-scripts---->
        <div class="clearfix"> </div>
    </div>
    <div class="clearfix"> </div>
</div>

{{-- @push('custom-js')
    <script>
        $(document).ready(function() {
            $('.custom-empty-cart').click(function(event) {
                event.preventDefault();
                var url = "{{ route('EmptyCart') }}";
                console.log(url);
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: JSON.stringify({
                        _token: '{{ csrf_token() }}'
                    }),
                    success: function(response) {
                        console.log(response);
                        alert('Cart emptied successfully!');
                    },
                    error: function(response) {
                        console.log(response);
                        alert('Error occurred while emptying the cart!');
                    }
                });
            });
        });
    </script>
@endpush --}}
