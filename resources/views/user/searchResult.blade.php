@extends('user.layout.layout')
@section('content')
    <div class="container-fluid">

        <div class="heading-title text-center" style="padding-top: 25px">
            <h2 class="">Search result</h2>
            <p>
                @if ($products->isNotEmpty())
                    <p>There are <span style="font-weight: bold">{{ $countResult }}</span> products that match the keyword
                    <span style="font-weight: bold">{{ $keyword }}</span></p>
                @else
                    There is no product hit keyword
                @endif
            </p>
        </div>
        @if ($products->isNotEmpty())
            <ul class="content-home cbp-vm-switcher" style="list-style: none; padding-top:5px">
                @foreach ($products as $product)
                    <li class="simpleCart_shelfItem col-sm-4">
                        <div class="view view-first">
                            <a class="cbp-vm-image" href="{{ route('detailPrd', $product->id) }}"></a>
                            <div class="inner_content clearfix">
                                <div class="product_image">
                                    <div class="mask1"><img
                                            src="{{ Storage::disk('s3')->temporaryUrl("thumbs"."/". $product->thumbnail->name, '+2 minutes')  }}"
                                            alt="image" class="img-responsive zoom-img"></div>


                                    <div class="product_container"><a class="cbp-vm-image"
                                            href="{{ route('detailPrd', $product->id) }}">
                                            <h4>{{ $product->name }}</h4>

                                            <div class="price mount item_price">$ {{ $product->price }}</div>
                                        </a>
                                        <a class="button item_add cbp-vm-icon cbp-vm-add add-to-cart" href="#"
                                            data-product-id="{{ $product->id }}">Add to cart</a>
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
        <div class="clearfix">
        </div>
        </ul>
    </div>
@endsection
