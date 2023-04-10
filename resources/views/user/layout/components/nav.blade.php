<div class="menu">
    <ul class="megamenu skyblue">
        <li><a class="color2" href="{{route('listWatches')}}">Watches</a>
            <div class="megapanel">
                <div class="row">
                    <div class="col1">
                        <div class="h_nav">

                            <ul>
                                @foreach ($watchCategories as $watchCategory)
                                    <li><a href="#">{{ $watchCategory->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </li>
        <li><a class="color4" href="{{route('listBags')}}">Bags</a>
            <div class="megapanel">
                <div class="row">
                    <div class="col1">
                        <div class="h_nav">

                            <ul>
                                @foreach ($bagCategories as $bagCategory)
                                    <li><a href="#">{{ $bagCategory->name }}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </li>

        <li class="active grid"><a class="color3" href="index.html">Sale</a></li>
        <li><a class="color7" href="404.html">News</a></li>
        <div class="clearfix"> </div>
    </ul>
</div>
<div class="clearfix"> </div>


