@extends('user.layout.layout')
@section('content')
@include('user.layout.components.sidebarfilter')
<div class="col-md-8 mens_right">
    <div class="dreamcrub">
           <ul class="breadcrumbs">
            <li class="home">
               <a href="{{route('user.index')}}" title="Go to Home Page">Home</a>&nbsp;
               <span>&gt;</span>
            </li>
            <li class="home">&nbsp;
                Watches&nbsp;
            </li>
        </ul>
        <ul class="previous">
            <li><a href="index.html">Back to Previous Page</a></li>
        </ul>
        <div class="clearfix"></div>
       </div>
       <div class="mens-toolbar">
         <div class="sort">
              <div class="sort-by">
            <label>Sort By</label>
            <select>
                            <option value="">
                    Position                </option>
                            <option value="">
                    Name                </option>
                            <option value="">
                    Price                </option>
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
                <a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected" data-view="cbp-vm-view-grid" title="grid">Grid View</a>
                <a href="#" class="cbp-vm-icon cbp-vm-list" data-view="cbp-vm-view-list" title="list">List View</a>
            </div>
            <div class="pages">   
     <div class="limiter visible-desktop">
       <label>Show</label>
          <select>
                    <option value="" selected="selected">
            9                </option>
                    <option value="">
            15                </option>
                    <option value="">
            30                </option>
          </select> per page        
       </div>
      </div>
            <div class="clearfix"></div>
            <ul>
              <li class="simpleCart_shelfItem">
                    <a class="cbp-vm-image" href="single.html">
                     <div class="view view-first">
                         <div class="inner_content clearfix">
                        <div class="product_image">
                            <div class="mask1"><img src="images/m4.jpg" alt="image" class="img-responsive zoom-img"></div>
                            <div class="mask">
                                   <div class="info">Quick View</div>
                             </div>
                             <div class="product_container">
                               <h4>Lorem 2015</h4>
                               <p>Dresses</p>
                               <div class="price mount item_price">$99.00</div>
                               <a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
                             </div>		
                          </div>
                         </div>
                      </div>
                    </a>
                </li>
                <li class="simpleCart_shelfItem">
                    <a class="cbp-vm-image" href="single.html">
                      <div class="view view-first">
                         <div class="inner_content clearfix">
                        <div class="product_image">
                            <div class="mask1"><img src="images/m2.jpg" alt="image" class="img-responsive zoom-img"></div>
                             <div class="mask">
                                   <div class="info">Quick View</div>
                              </div>
                             <div class="product_container">
                               <h4>Lorem 2015</h4>
                               <p>Dresses</p>
                               <div class="price mount item_price">$99.00</div>
                               <a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
                             </div>		
                          </div>
                         </div>
                      </div>
                     </a>
                </li>
                <li class="last simpleCart_shelfItem">
                    <a class="cbp-vm-image" href="single.html">
                        <div class="view view-first">
                         <div class="inner_content clearfix">
                        <div class="product_image">
                            <div class="mask1"><img src="images/m3.jpg" alt="image" class="img-responsive zoom-img"></div>
                            <div class="mask">
                                   <div class="info">Quick View</div>
                              </div>
                            <div class="product_container">
                               <h4>Lorem 2015</h4>
                               <p>Dresses</p>
                                <div class="price mount item_price">$99.00</div>
                                <a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
                             </div>		
                          </div>
                         </div>
                      </div>
                    </a>
                </li>
                <li class="simpleCart_shelfItem">
                    <a class="cbp-vm-image" href="single.html">
                        <div class="view view-first">
                         <div class="inner_content clearfix">
                        <div class="product_image">
                            <div class="mask1"><img src="images/m1.jpg" alt="image" class="img-responsive zoom-img"></div>
                            <div class="mask">
                                   <div class="info">Quick View</div>
                              </div>
                            <div class="product_container">
                               <h4>Lorem 2015</h4>
                               <p>Dresses</p>
                               <div class="price mount item_price">$99.00</div>
                                <a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
                             </div>		
                          </div>
                         </div>
                      </div>
                    </a>
                </li>
                <li class="simpleCart_shelfItem">
                    <a class="cbp-vm-image" href="single.html">
                        <div class="view view-first">
                         <div class="inner_content clearfix">
                        <div class="product_image">
                            <div class="mask1"><img src="images/m5.jpg" alt="image" class="img-responsive zoom-img"></div>
                            <div class="mask">
                                   <div class="info">Quick View</div>
                              </div>
                            <div class="product_container">
                               <h4>Lorem 2015</h4>
                               <p>Dresses</p>
                                <div class="price mount item_price">$99.00</div>
                                <a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
                             </div>		
                          </div>
                         </div>
                      </div>
                    </a>
                </li>
                <li class="last simpleCart_shelfItem">
                    <a class="cbp-vm-image" href="single.html">
                        <div class="view view-first">
                         <div class="inner_content clearfix">
                        <div class="product_image">
                            <div class="mask1"><img src="images/m6.jpg" alt="image" class="img-responsive zoom-img"></div>
                            <div class="mask">
                                   <div class="info">Quick View</div>
                              </div>
                            <div class="product_container">
                               <h4>Lorem 2015</h4>
                               <p>Dresses</p>
                                <div class="price mount item_price">$99.00</div>
                                <a class="button item_add cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
                             </div>		
                          </div>
                         </div>
                      </div>
                    </a>
                </li>
            </ul>
        </div>
        <script src="js/cbpViewModeSwitch.js" type="text/javascript"></script>
        <script src="js/classie.js" type="text/javascript"></script>
</div>
@endsection
@push('custom-js')
@endpush