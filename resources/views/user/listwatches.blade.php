@extends('user.layout.layout')
@section('content')
    {{-- @include('user.layout.components.sidebarfilter') --}}
    <div class="col-md-4 sidebar_men">
      <h3>Categories</h3>
      <ul class="product-categories color sidebar">
        @foreach ($watchCategories as $watchCategory)
        <li class="cat-item cat-item-60"><a href="{{route('listChildBags', $watchCategory->id)}}" class="category-link" data-category-id="{{ $watchCategory->id }}">{{$watchCategory->name}}</a> <span class="count">({{ $watchCategory->products_count }})</span></li>
        @endforeach
     </ul>
      <h3>Colors</h3>
      <ul class="product-categories color"><li class="cat-item cat-item-42"><a href="#">Green</a> <span class="count">(14)</span></li>
        <li class="cat-item cat-item-60"><a href="#">Blue</a> <span class="count">(2)</span></li>
        <li class="cat-item cat-item-63"><a href="#">Red</a> <span class="count">(2)</span></li>
        <li class="cat-item cat-item-54"><a href="#">Gray</a> <span class="count">(8)</span></li>
        <li class="cat-item cat-item-55"><a href="#">Green</a> <span class="count">(11)</span></li>
      </ul>
      <h3>Sizes</h3>
      <ul class="product-categories color"><li class="cat-item cat-item-42"><a href="#">L</a> <span class="count">(14)</span></li>
        <li class="cat-item cat-item-60"><a href="#">M</a> <span class="count">(2)</span></li>
        <li class="cat-item cat-item-63"><a href="#">S</a> <span class="count">(2)</span></li>
        <li class="cat-item cat-item-54"><a href="#">XL</a> <span class="count">(8)</span></li>
        <li class="cat-item cat-item-55"><a href="#">XS</a> <span class="count">(11)</span></li>
      </ul>
      <h3>Price</h3>
      <ul class="product-categories">
        <li class="cat-item cat-item-42"><a href="#">0$-200$</a> <span class="count">(14)</span></li>
        <li class="cat-item cat-item-42"><a href="#">200$-400$</a> <span class="count">(14)</span></li>
        <li class="cat-item cat-item-60"><a href="#">400$-600$</a> <span class="count">(2)</span></li>
        <li class="cat-item cat-item-63"><a href="#">600$-800$</a> <span class="count">(2)</span></li>
        <li class="cat-item cat-item-54"><a href="#">800$~</a> <span class="count">(8)</span></li>
      
      </ul>
    </div>
    <div class="col-md-8 mens_right">
        <div class="dreamcrub">
            <ul class="breadcrumbs">
                <li class="home">
                    <a href="{{ route('index') }}" title="Go to Home Page">Home</a>&nbsp;
                    <span>&gt;</span>
                </li>
                <li class="home">&nbsp;
                    Watches&nbsp;
                </li>
            </ul>
            
            <div class="clearfix"></div>
        </div>
        <div class="mens-toolbar">
            <div class="sort">
                <div class="sort-by">
                    <label>Sort By</label>
                    <select>
                        <option value="">
                            Position </option>
                        <option value="">
                            Name </option>
                        <option value="">
                            Price </option>
                    </select>
                    <a href=""><img src="images/arrow2.gif" alt="" class="v-middle"></a>
                </div>
            </div>
            {{-- <ul class="women_pagenation dc_paginationA dc_paginationA06">
                <li><a href="#" class="previous">Page : </a></li>
                @if ($prds->lastPage > 1)
                @for ($i = 1; $i <= $prds->lastPage; $i++)
                @if ($i === $prd->currentPage())
                <li class="active">{{$i}}</li>
                @else
                <li><a href="{{$prd->url($i)}}">{{$i}}</a></li>
                @endfor
               @endif
               <li class="next"><a href="{{$prd->getNextPage()}}">Next</a></li>
               <li class="next"><a href="{{route('category',['page'=>$prd->currentPage()+1]}}">Next</a></li> 
            </ul> --}}
           
            <div class="clearfix"></div>
        </div>
        <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">


            <div class="clearfix"></div>
            <div class="product-list">
                <ul>
                    @if ($products->isNotEmpty())
                        <ul class="content-home cbp-vm-switcher" style="list-style: none; padding-top:5px">
                            @foreach ($products as $product)
                                <li class="simpleCart_shelfItem col-sm-4">
                                    <div class="view view-first">
                                        <a class="cbp-vm-image" href="{{ route('detailPrd', $product->id) }}"></a>
                                        <div class="inner_content clearfix">
                                            <div class="product_image">
                                                <div class="mask1">
                                                    <img src="{{ asset('storage/thumbnail/' . $product->thumbnail->name) }}"alt="image"
                                                        class="img-responsive zoom-img">
                                                </div>
                                                <div class="product_container"><a class="cbp-vm-image"
                                                        href="{{ route('detailPrd', $product->id) }}">
                                                        <h4>{{ $product->name }}</h4>

                                                        <div class="price mount item_price">$ {{ $product->price }}</div>
                                                    </a><a class="button item_add cbp-vm-icon cbp-vm-add add-to-cart" data-product-id="{{ $product->id }}"href="#">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="clearfix"> </div>
                        <div style="float: right">
                            {{ $products->links() }}
                        </div>
                    @endif
                </ul>
            </div>
        </div>

    </div>


@endsection
@push('custom-js')
    <script src="{{ asset('user/js/cbpViewModeSwitch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('user/js/classie.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.category-link').click(function(e) {
                e.preventDefault();
                var categoryId = $(this).data('category-id');
                var url = "{{ route('listChildWatches', ':categoryId') }}".replace(':categoryId', categoryId);
                console.log(categoryId);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('.product-list').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });


        // $(document).ready(function() {
        //     $('.category-link').click(function(e) {
        //         e.preventDefault();

        //         var categoryId = $(this).data('category-id');
        //         var url = "{{ route('listChildBags', ':categoryId') }}".replace(':categoryId', categoryId);


        //         $('.category-link').removeClass('active');
        //         $(this).addClass('active');

        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(response) {
        //                 var productsHtml = '';

        //                 $.each(response.products, function(index, product) {
        //                     var productHtml =
        //                         '<li class="simpleCart_shelfItem col-sm-4">' +
        //                         '<div class="view view-first">' +

        //                         '<a class="cbp-vm-image" href=\'{{ route('detailPrd', ':productId') }}\'.replace(":productId", product.id)></a>' +
        //                         '<div class="inner_content clearfix">' +
        //                         '<div class="product_image">' +
        //                         '<div class="mask1">' +

        //                         '<img src="{{ asset('storage/thumbnail') }}/'+product.thumbnail.name+'" alt="image" class="img-responsive zoom-img">' +

        //                         '</div>' +
        //                         '<div class="product_container">' +

        //                         '<a class="cbp-vm-image" href="{{ route('detailPrd', ':productId') }}".replace(":productId", product.id)>'
        //                         '<h4>' + product.name + '</h4>' +
        //                         '<div class="price mount item_price">$ ' + product
        //                         .price + '</div>' +
        //                         '</a>' +
        //                         '<a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</li>';

        //                     productsHtml += productHtml;
        //                 });

        //                 $('.product-list').html(
        //                     '<ul class="content-home cbp-vm-switcher" style="list-style: none; padding-top:5px">' +
        //                     productsHtml + '</ul>');
        //             },
        //             error: function(xhr, status, error) {
        //                 console.log(xhr.responseText);
        //             }
        //         });
        //     });
        // });
    </script>
@endpush
