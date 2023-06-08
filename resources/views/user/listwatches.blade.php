@extends('user.layout.layout')
@section('content')
    {{-- @include('user.layout.components.sidebarfilter') --}}
    <div class="col-md-4 sidebar_men">
        <h3>Categories</h3>
        <ul class=" product-categories color sidebar">
            @foreach ($watchCategories as $watchCategory)
                <li
                    class="cat-item cat-item-60 category_item {{ isset($active_category_id) && $watchCategory->id == $active_category_id ? 'active' : '' }}{{ Request::segment(2) == $watchCategory->id ? 'active' : '' }}">
                    <a href="{{ route('listChildBags', $watchCategory->id) }}"
                        class="category-link {{ isset($active_category_id) && $watchCategory->id == $active_category_id ? 'active' : '' }}"
                        data-category-id="{{ $watchCategory->id }}">
                        {{ $watchCategory->name }}
                    </a>
                    {{-- <span class="count">({{ $watchCategory->products_count }})</span> --}}
                    <span class="count">({{  $products_count[$watchCategory->id] }})</span>
                </li>
            @endforeach

        </ul>

        <h3>Colors</h3>{{ $prd_count['0-300'] }}
        <ul class="product-categories color">
            <li class="cat-item cat-item-42"><a href="#">Green</a> <span class="count">(14)</span></li>
            <li class="cat-item cat-item-60"><a href="#">Blue</a> <span class="count">(2)</span></li>
            <li class="cat-item cat-item-63"><a href="#">Red</a> <span class="count">(2)</span></li>
            <li class="cat-item cat-item-54"><a href="#">Gray</a> <span class="count">(8)</span></li>
            <li class="cat-item cat-item-55"><a href="#">Green</a> <span class="count">(11)</span></li>
        </ul>

        <h3>Price</h3> 
        <ul class="product-price color sidebar product-categories">
            <li class="cat-item cat-item-42">
                <a href="{{ route('listWatches', ['price_range' => '0-300']) }}" class="price-link" data-price-range="0-300">0$-300$</a>
                <span class="count">({{ $prd_count['0-300'] }})</span>
            </li>
            <li class="cat-item cat-item-42">
                <a href="{{ route('listWatches', ['price_range' => '300-600']) }}" class="price-link" data-price-range="300-600">300$-600$</a>
                <span class="count">({{ $prd_count['300-600'] }})</span>
            </li>
            <li class="cat-item cat-item-54">
                <a href="{{ route('listWatches', ['price_range' => '600-']) }}" class="price-link" data-price-range="600-">600$~</a>
                <span class="count">({{ $prd_count['600+'] }})</span>
            </li>
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
            <form action="{{ route('listWatches') }}" method="get" id="form-filter">
                <div class="sort">
                    <div class="sort-by">
                        <label>Sort By</label>
                        <select name="sort_key" class="product-filter">
                            <option value="az" @if ($sort_key == 'az') selected @endif>
                                A->Z
                            </option>
                            <option value="za" @if ($sort_key == 'za') selected @endif>
                                Z->A
                            </option>
                            <option value="price_up" @if ($sort_key == 'price_up') selected @endif>
                                Price up
                            </option>
                            <option value="price_down" @if ($sort_key == 'price_down') selected @endif>
                                Price down
                            </option>
                        </select>
                        <a href=""><img src="images/arrow2.gif" alt="" class="v-middle"></a>
                    </div>
                </div>
            </form>

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
            {{-- @if (isset($active_category_id))
                {{ hi }}
            @endif --}}
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
                                                    <img src="{{ Storage::disk('s3')->temporaryUrl("thumbs"."/". $product->thumbnail->name, '+2 minutes')  }}"alt="image"
                                                        class="img-responsive zoom-img">
                                                </div>
                                                <div class="product_container"><a class="cbp-vm-image"
                                                        href="{{ route('detailPrd', $product->id) }}">
                                                        <h4>{{ $product->name }}</h4>

                                                        <div class="price mount item_price">$ {{ $product->price }}</div>
                                                    </a><a class="button item_add cbp-vm-icon cbp-vm-add add-to-cart"
                                                        href="#" data-product-id="{{ $product->id }}">Add to
                                                        cart</a>
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
                    @else
                    <h3>data not found </h3>
                    @endif
                </ul>
            </div>
        </div>

    </div>


@endsection
@push('custom-js')
    <script src="{{ asset('user/js/cbpViewModeSwitch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('user/js/classie.js') }}" type="text/javascript"></script>
    {{-- js for sort function --}}
    <script>
        $(document).ready(function() {
    var activeCategoryId = $('.category-link.active').data('category-id');

    $('.category-link').click(function(e) {
        e.preventDefault();

        var categoryId = $(this).data('category-id');
        var sortKey = $('.product-filter').val();
        var priceRange = $('.price-link.active').data('price-range');
        var url = "{{ url('watches') }}/" + categoryId;
        var url2 = "{{ url('watches') }}";
        $('.category-link').not(this).removeClass('active');
        $(this).toggleClass('active');
    
        
    // Check if the filter is active or not
    if ($(this).hasClass('active')) {
        // Perform the AJAX request with the price range
        performAjaxRequest(url, sortKey, priceRange);
    } else {
        // Perform the AJAX request without the price range
        performAjaxRequest(url2, sortKey, priceRange);
    }
        
    });

    //this is sortkey
    $('.product-filter').on('change', function() {
        var categoryId = $('.category-link.active').data('category-id');
        var sortKey = $(this).val();
        var priceRange = $('.price-link.active').data('price-range');
        var url = "{{ url('watches') }}/" + (categoryId ? categoryId : '');
        performAjaxRequest(url, sortKey, priceRange);
    });

   


    $('.price-link').click(function(e) {
    e.preventDefault();

    var priceRange = $(this).data('price-range');
    console.log(priceRange);
    var sortKey = $('.product-filter').val();
    var categoryId = $('.category-link.active').data('category-id');
    var url = "{{ url('watches') }}/" + (categoryId ? categoryId : '');
    console.log(url);

    $('.price-link').not(this).removeClass('active');
    $(this).toggleClass('active');


    // Check if the filter is active or not
    if ($(this).hasClass('active')) {
        // Perform the AJAX request with the price range
        performAjaxRequest(url, sortKey, priceRange);
    } else {
        // Perform the AJAX request without the price range
        performAjaxRequest(url, sortKey);
    }
});
});

function performAjaxRequest(url, sortKey, priceRange) {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        data: {
            sort_key: sortKey,
            price_range: priceRange
        },
        success: function(response) {
            $('.product-list').html(response);
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

    </script>
@endpush
