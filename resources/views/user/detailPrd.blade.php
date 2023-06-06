@extends('user.layout.layout')
@section('content')
    <div class="container">
        <div class="col-md-9 single_top">
            <div class="single_left">
                <div class="labout span_1_of_a1">
                    <div class="flexslider">
                        <ul class="slides">
                            <li data-thumb="{{ asset('storage/thumbnail/' . $product->thumbnail->name) }}">
                                <img src="{{ asset('storage/thumbnail/' . $product->thumbnail->name) }}" />
                            </li>
                            @foreach ($images as $image)
                                <li data-thumb="{{ asset('storage/images/' . $image->name) }}">
                                    <img src="{{ asset('storage/images/' . $image->name) }}" alt="">
                    
                    @endforeach
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="cont1 span_2_of_a1 simpleCart_shelfItem">
                <h1>{{ $product->name }}</h1>
                <p class="availability">Availability: <span class="color">In stock</span></p> 
                <div class="price_single">
                    {{-- tạm thời chưa làm logic sale price --}}
                    {{-- <span class="reducedfrom">{{$product->price}}</span> --}}
                    <p >Price:  <span class="amount item_price actual">$ {{ $product->price }}</span></p>
                </div>
                <h2 class="quick">Quick Overview:</h2>
                @php
                    $description =strip_tags($product->description ?? '');
                @endphp
                <p class="quick_desc">{{ $description }} </p>
                <div class="wish-list">
                    <ul>
                        <li class="wish"><a href="#">Add to Wishlist</a></li>
                    </ul>
                </div>
                <ul class="color size">
                    <h3>Color</h3>
                    <li><a href="#">Pink</a></li>
                    <li><a href="#">White</a></li>
                </ul>
                <div class="quantity_box">
                    <ul class="product-qty">
                        <span>Quantity:</span>
                        <select class="quantity-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <a href="{{ route('AddToCart', $product->id) }}"
                    class="btn btn-primary btn-normal btn-inline btn_form button item_add item_1 add-to-cart" data-product-id="{{ $product->id }}"target="_self">Add to cart</a>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="sap_tabs">
            <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
                <ul class="resp-tabs-list">
                    <li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span>Product Description</span>
                    </li>
                    <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span>Return Policy</span>
                    </li>
                </ul>
                <div class="resp-tabs-container">
                    <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
                        <div class="facts">
                            <ul class="tab_list">
                                @php
                                    $content = strip_tags($product->content ?? '');
                                @endphp
                                <li>{{ $content }}</li>

                            </ul>
                        </div>
                    </div>
                    <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
                        <div class="facts">
                            <ul class="tab_list">
                                <li>augue duis dolore te feugait nulla facilisi. Nam liber tempor cum
                                    soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat
                                    facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui
                                    facit eorum claritatem. Investigatione</li>
                                <li>claritatem insitam; est usus legentis in iis qui facit eorum
                                    claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt
                                    saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem
                                    consuetudium lectorum. Mirum est notare quam littera gothica</li>
                                <li>Mirum est notare quam littera gothica, quam nunc putamus parum claram,
                                    anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta
                                    decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in
                                    futurum.</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if($relatedProducts->isNotEmpty())
    <div class="col-md-3 tabs">
        <h3 class="m_1">Related Products</h3>
        @foreach($relatedProducts as $relatedProduct)
        <ul class="product">
            <li class="product_img"><img src="{{ asset('storage/thumbnail/' . $relatedProduct->thumbnail->name) }}" class="img-responsive" alt="thumbnail" /></li>
            <li class="product_desc">
                <h4><a href="{{ route('detailPrd', $relatedProduct->id) }}">{{$relatedProduct->name}}</a></h4>
                <p class="single_price">$ {{$relatedProduct->price}}</p>
                <a href="#" class="link-cart">Add to Wishlist</a>
                <a href="{{ route('AddToCart', $relatedProduct->id) }}"
                    class="link-cart item_add item_1 add-to-cart" data-product-id="{{ $relatedProduct->id }}"target="_self">Add to cart</a>
            </li>
            <div class="clearfix"> </div>
        </ul>
        @endforeach
        
    </div>
    @endif
    <div class="clearfix"> </div>
    </div>
@endsection
@push('custom-js')
    <script src="{{ asset('user/js/easyResponsiveTabs.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#horizontalTab').easyResponsiveTabs({
                type: 'default', //Types: default, vertical, accordion           
                width: 'auto', //auto or any width like 600px
                fit: true // 100% fit in a container
            });
        });
    </script>

    <!-- FlexSlider -->
    <script defer src="{{ asset('user/js/jquery.flexslider.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('user/css/flexslider.css') }}" type="text/css" media="screen" />
    <script>
        // Can also be used with $(document).ready()
        $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
        });
    </script>
@endpush
