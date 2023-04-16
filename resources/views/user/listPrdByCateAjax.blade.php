<div class="product-list">
    <div> 
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
                                        </a><a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
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