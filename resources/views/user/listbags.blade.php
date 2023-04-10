@extends('user.layout.layout')
@section('content')
    @include('user.layout.components.sidebarfilter')
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
            <ul class="previous">
                <li><a href="{{ route('index') }}">Back to Previous Page</a></li>
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
            <ul class="women_pagenation dc_paginationA dc_paginationA06">
                <li><a href="#" class="previous">Page : </a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
            <div class="cbp-vm-options">
                <a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected" data-view="cbp-vm-view-grid"
                    title="grid">Grid View</a>
                <a href="#" class="cbp-vm-icon cbp-vm-list" data-view="cbp-vm-view-list" title="list">List View</a>
            </div>

            <div class="clearfix"></div>
            <ul>
                @if ($listBags->isNotEmpty())
                    <ul class="content-home cbp-vm-switcher" style="list-style: none; padding-top:5px">
                        @foreach ($listBags as $bag)
                            <li class="simpleCart_shelfItem col-sm-4">
                                <div class="view view-first">
                                    <a class="cbp-vm-image" href="{{ route('detailPrd', $bag->id) }}"></a>
                                    <div class="inner_content clearfix">
                                        <div class="product_image">
                                            <div class="mask1">
                                                <img src="{{ asset('storage/thumbnail/' . $bag->thumbnail->name) }}"alt="image" class="img-responsive zoom-img"></div>


                                            <div class="product_container"><a class="cbp-vm-image" href="{{ route('detailPrd', $bag->id) }}">
                                                    <h4>{{ $bag->name }}</h4>

                                                    <div class="price mount item_price">$ {{ $bag->price }}</div>
                                                </a><a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to
                                                    cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                @endif
                <div class="clearfix"> </div>
            </ul>
            </ul>
        </div>
        <script src="js/cbpViewModeSwitch.js" type="text/javascript"></script>
        <script src="js/classie.js" type="text/javascript"></script>
    </div>
@endsection
@push('custom-js')
@endpush
