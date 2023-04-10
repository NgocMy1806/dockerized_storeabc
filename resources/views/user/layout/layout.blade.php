<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Watches an E-Commerce online Shopping Category Flat Bootstrap Responsive Website Template| Home :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Watches Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="{{asset('user/css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Custom Theme files -->
<link href="{{asset('user/css/style.css')}}" rel='stylesheet' type='text/css' />
<link  href="{{asset('user/css/flexslider.css')}}"rel="stylesheet" type="text/css" media="screen" />
<!-- Custom Theme files -->
<!--webfont-->

<script type="text/javascript" src="{{asset('user/js/jquery-1.11.1.min.js')}}"></script>
<!-- start menu -->
<link href="{{asset('user/css/megamenu.css')}}"rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="{{asset('user/js/megamenu.js')}}"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<script src="{{asset('user/js/jquery.easydropdown.js')}}"></script>
<script src="{{asset('user/js/simpleCart.min.js')}}"> </script>

<script src="{{asset('user/js/easyResponsiveTabs.js')}}" type="text/javascript"></script>
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
	<div class="banner">
   	  <div class="container">
   	  	@include('user.layout.components.headertop')
	  <div class="header_bottom">

        {{-- slider để chuyển banner --}}
	   <div class="logo">
		  <h1><a href="{{route('index')}}"><span class="m_1">W</span>atches</a></h1>
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
</body>
</html>		