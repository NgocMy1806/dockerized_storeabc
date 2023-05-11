@extends('user.layout.layout')
@section('content')
    {{-- @include('user.layout.components.sidebarfilter') --}}
    <div class="col-md-4 sidebar_men">
        <h3>Categories</h3>
        <ul class="product-categories color sidebar">
            @foreach ($bagCategories as $bagCategory)
                <li class="cat-item cat-item-60"><a href="{{ route('listChildBags', $bagCategory->id) }}" class="category-link"
                        data-category-id="{{ $bagCategory->id }}">{{ $bagCategory->name }}</a> <span
                        class="count">({{ $bagCategory->products_count }})</span></li>
            @endforeach
        </ul>
        <h3>Colors</h3>
        <ul class="product-categories color">
            <li class="cat-item cat-item-42"><a href="#">Green</a> <span class="count">(14)</span></li>
            <li class="cat-item cat-item-60"><a href="#">Blue</a> <span class="count">(2)</span></li>
            <li class="cat-item cat-item-63"><a href="#">Red</a> <span class="count">(2)</span></li>
            <li class="cat-item cat-item-54"><a href="#">Gray</a> <span class="count">(8)</span></li>
            <li class="cat-item cat-item-55"><a href="#">Green</a> <span class="count">(11)</span></li>
        </ul>
        
        <h3>Price</h3>
        <ul class="product-price">
            <li class="cat-item cat-item-42"><a href="{{ route('listBags', ['price_range' => '0-300']) }}">0$-300$</a> <span class="count">({{$bags_count['0-300']}})</span></li>
            <li class="cat-item cat-item-42"><a href="{{ route('listBags', ['price_range' => '300-600']) }}">300$-600$</a> <span class="count">({{$bags_count['300-600']}})</span></li>
            <li class="cat-item cat-item-54"><a href="{{ route('listBags', ['price_range' => '600-']) }}">600$~</a> <span class="count">({{$bags_count['600+']}})</span></li>
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
                    Bags&nbsp;
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="mens-toolbar">
            <form action="{{ route('listBags') }}" method="get" id="form-filter">
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
        // $(document).ready(function() {
        //     $('.product-filter').on('change', function() {
        //         console.log('hi');
        //         $('#form-filter').submit();
        //     });
        // });


        $(document).ready(function() {
    $('.product-filter').on('change', function() {
        var categoryId = getCategoryIdFromURL()?getCategoryIdFromURL():''; // Retrieve the category ID from the URL
        var sortKey = $(this).val(); // Get the selected sort key
        var url = "{{ url('bags') }}/" + categoryId + "?sort_key=" + sortKey;
        console.log(categoryId);
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                $('.product-list').html(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
       
        });
    });

    function getCategoryIdFromURL() {
    var url = window.location.href;
    var categoryId = null;
    var parts = url.split('/');
    var lastIndex = parts.length - 1;
    if (lastIndex > 0 && parts[lastIndex] !== 'bags') {
        categoryId = parts[lastIndex];
    }
    return categoryId;
}
        })
;

    </script>
    
    <script>
        $(document).ready(function() {
            $('.category-link').click(function(e) {
                e.preventDefault();
                var categoryId = $(this).data('category-id');
                // var url = "{{ route('listChildBags', ':categoryId') }}".replace(':categoryId', categoryId);
                var url = "{{ url('bags') }}/" + categoryId;
                window.location.href = url;
                console.log(categoryId);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html', //server trả ra data là file view luôn, nghĩa là vẫn là server side rendering
                    success: function(response) {
                        $('.product-list').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

   
@endpush
