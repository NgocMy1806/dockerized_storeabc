<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>

<head>
    <title>Watches an E-Commerce online Shopping Category Flat Bootstrap Responsive Website Template| Home :: w3layouts
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Watches Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href="{{ asset('user/css/bootstrap.css') }}" rel='stylesheet' type='text/css' />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Custom Theme files -->
    <link href="{{ asset('user/css/style.css') }}" rel='stylesheet' type='text/css' />
    {{-- <link href="{{asset('user/css/component.css')}}" rel='stylesheet' type='text/css' /> --}}
    <link href="{{ asset('user/css/flexslider.css') }}"rel="stylesheet" type="text/css" media="screen" />
    <!-- Custom Theme files -->
    <!--webfont-->

    <script type="text/javascript" src="{{ asset('user/js/jquery-1.11.1.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script> --}}
    <!-- start menu -->
    <link href="{{ asset('user/css/megamenu.css') }}"rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="{{ asset('user/js/megamenu.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".megamenu").megamenu();
        });
    </script>
    <script src="{{ asset('user/js/jquery.easydropdown.js') }}"></script>
    <script src="{{ asset('user/js/simpleCart.min.js') }}"></script>

    <script src="{{ asset('user/js/easyResponsiveTabs.js') }}" type="text/javascript"></script>
    {{-- <script type="text/javascript">
		$(document).ready(function () {
			$('#horizontalTab').easyResponsiveTabs({
				type: 'default', //Types: default, vertical, accordion           
				width: 'auto', //auto or any width like 600px
				fit: true   // 100% fit in a container
			});
		});
	</script> --}}

</head>

<body>
    <!--<div class="banner" style="min-height:341.510px; margin-bottom: 40px;">-->
    <!--<div class=" {{ env('APP_ENV') !== 'local' ? 'banner-cloudfront' : 'banner-local' }} banner" style="min-height:341.510px; margin-bottom: 40px;">-->
        <div class="banner" style="{{ env('APP_ENV') !== 'local' ? 'background: url('.env('CLOUDFRONT_DOMAIN').'/common/3.jpg) no-repeat center top' : 'background: url(../images/3.jpg) no-repeat center top' }}; min-height: 341.510px; margin-bottom: 40px;">

        <div class="container">
            @include('user.layout.components.headertop')
            <div class="header_bottom">

                {{-- slider để chuyển banner --}}
                <div class="logo">
                    <h1><a href="{{ route('index') }}"><span class="m_1">W</span>ab</a></h1>
                </div>
                {{-- nav menu --}}
                @include('user.layout.components.nav')
            </div>
        </div>
    </div>
    <div class="main">


        @yield('content')

    </div>
    @include('user.layout.components.footer')
    @stack('custom-js')

    {{-- add to cart js --}}
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function(event) {
                event.preventDefault();

                var productId = $(this).data('product-id');
                var quantity = 1; // Default quantity is 1
                var quantitySelect = $('.quantity-select').val();
                console.log(quantitySelect);
                if (quantitySelect) {
                    quantity = quantitySelect; // Get the selected quantity
                }
                var url = "{{ route('AddToCart', ':productId') }}".replace(':productId', productId);
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

                        $('#cart-total').html('$' + response.total.toFixed(2));
                        $('#cart-count').text(response.totalQuantity);
                        alert('Add to cart successfully!');
                        // update the cart count in the session
                        // sessionStorage.setItem('cartCount', response.totalQuantity);
                    },
                    error: function(response) {
                        console.log(response);
                        alert('Error occurred while adding the product to the cart!');
                    }
                });
            });
        });
    </script>
</body>

</html>
