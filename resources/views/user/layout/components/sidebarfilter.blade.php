<div class="col-md-4 sidebar_men">
    <h3>Categories</h3>
    <ul class="product-categories color">
      @foreach ($bagCategories as $bagCategory)
      <li class="cat-item cat-item-60"><a href="{{route('listChildBags', $bagCategory->id)}}">{{$bagCategory->name}}</a> <span class="count">({{ $bagCategory->products_count }})</span></li>
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
    <ul class="product-categories"><li class="cat-item cat-item-42"><a href="#">200$-300$</a> <span class="count">(14)</span></li>
      <li class="cat-item cat-item-60"><a href="#">300$-400$</a> <span class="count">(2)</span></li>
      <li class="cat-item cat-item-63"><a href="#">400$-500$</a> <span class="count">(2)</span></li>
      <li class="cat-item cat-item-54"><a href="#">500$-600$</a> <span class="count">(8)</span></li>
      <li class="cat-item cat-item-55"><a href="#">600$-700$</a> <span class="count">(11)</span></li>
    </ul>
  </div>