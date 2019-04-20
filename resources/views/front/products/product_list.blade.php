    @extends('layouts.home') 
@section('content')

<style>
	#myModal_view{
		top:0px!important;
  }
    .listing_product_show_row .sticky {
  position: -webkit-sticky !important;
  position: sticky;
  top: 0;
  

	}
</style>
      <section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec">
         <div class="container">
            <div class="row sort_topp">
               <div class="col-md-3">
                   @if($title)
                  <h3>{{ucfirst($title)}}</h3>
                  @endif
               </div>
               <div class="col-md-9">
                  <ul>
                     <li class="active_sort"><a href="javascript::void(0);">Sort By</a></li>
<!--                     <li>
                        <a href="#">
                           Popularity
                     </li>-->
                     <li><a href="#">@sortablelink('price', 'Price')</a></li>
<!--                     <li><a href="#">@sortablelink('created_at', 'Price - High to Low')</a></li>-->
                     <li><a href="#">@sortablelink('created_at', 'Newest First')</a></li>
                  </ul>
                   <?php $i = $products2->perPage() * ($products2->currentPage() - 1);
                   //echo $i.'dd'.$products->perPage().'fff'.$products->currentPage().'ssfff'.$products->count();
                   ?>
                  <p>Showing {{$i+1}}–{{$products2->count()}} of {{$products2->total()}} results</p>
               </div>
            </div>
            <div class="row no-gutters listing_product_show_row">
               <div class="col-md-3 side_stick sticky" >
                  <h2>Filters</h2>
                  <a href="{{URL::to($URL)}}" class="clear">Clear all</a>
                  {!! Form::open(array('novalidate' => 'novalidate','method' => 'GET','id'=>'search_form','name'=>'search_form')) !!}
                 
                  <div class="col-md-12 mean_cat">
                      @if(!empty($category_lists))
                      <?php //$catLists = CommonHelpers::getcatlist(); ?>
                      @foreach($category_lists as $key=>$catList)
                     <label class="container_checkbx">{{ ucfirst($catList->cat_name) }}
                         
                      <input type="checkbox" name="cats[]" value="{{$catList->id}}" <?php if(in_array($catList->id,$catArr)){?> checked="checked" <?php }?> />
                          
                     <span class="checkmark_checkbx"></span>
                     </label>
                     @endforeach   
                     @endif
                  </div>
                  
                             
                  <div class="col-md-12 size">
                     <h2  onclick="myFunction_in()" id="flip_size">Size 
                         <i class="fa fa-angle-down" aria-hidden="true"></i></h2>
                     <div class="p">
                        <span id="dots_in"></span>
                        <ul id="panel_size">
                            
                           @foreach($sizeLists as $key=>$value)                           
                           <li class="<?if($key==0){?>active_size<?}?>">
                              <?php /*?>{!! Form::checkbox('sizes[]',$value->id, Input::get('size'), array(
                                    'required', 
                                    'class' => ''
                            )); !!}<?php */?>
                               
                               
                               <input type="checkbox" name="sizes[]" value="{{$value->id}}" <?php if(in_array($value->id,$sizeArr)){?> checked="checked" <?php }?> />                   
                               <a href="#">{{$value->size}}</a>                  
                           </li>                           
                           @endforeach
                           
                        </ul>
                     </div>
                  </div>
                  
                  
                  <div class="col-md-12 color_product">
                     <h2  onclick="myFunction_color()" id="flip_color">Color <i class="fa fa-angle-down" aria-hidden="true"></i></h2>
                     <div class="p">
                        <span id="dots_color"></span>
                        <div id="panel_color">
                          
                            <?php $colorLists = CommonHelpers::getcolorlist();?>
                               @foreach($colorLists as $key=>$colorList)
                           <label class="container_checkbx">{{ucfirst($colorList->color_name)}}
                               
                           <input type="checkbox" name="colors[]" value="{{$colorList->id}}" <?php if(in_array($colorList->id,$colorArr)){?> checked="checked" <?php }?> />
                           
                           <span class="ck_span"  style="background:{{$colorList->color_picker}};"></span> 
                           <span class="checkmark_checkbx"></span>
                           </label>
                           @endforeach
                           
                            </div>
                     </div>
                  </div>
                  
                 
                  <script> 
                     $(document).ready(function(){
                         $("#flip_color").click(function(){
                             $("#panel_color").slideToggle(300);
                         });
                     });
                  </script>
                  <script>
                     function myFunction_color() {
                       var dots_color = document.getElementById("dots_color");
                       var moreText_color = document.getElementById("panel_color");
                       var btnText_color = document.getElementById("flip_color");
                     
                       if (dots_color.style.display === "none") {
                         dots_color.style.display = "inline";
                         btnText_color.innerHTML = 'Color <i class="fa fa-angle-down" aria-hidden="true"></i>'; 
                         
                       } else {
                         dots_color.style.display = "none";
                         btnText_color.innerHTML = 'Color <i class="fa fa-angle-up" aria-hidden="true"></i>'; 
                        
                       }
                     }
                  </script>
                  <div class="col-md-12 product_pricee">
                     <h2  onclick="myFunction_price()" id="flip_price">Price <i class="fa fa-angle-down" aria-hidden="true"></i></h2>
                     <div class="p">
                        <span id="dots_price"></span>
                        <div id="panel_price">
                          
                            <script>
                              $(document).ready(function() {
                                  var minprice = '<?=$minArr?>' || 0;
                                  var maxprice = '<?=$maxArr?>' || 999;
                              $( "#mySlider" ).slider({
                                range: true,
                                min: 0,
                                max: 999,
                                values: [ minprice, maxprice ],
                                stop: function( event, ui ) { console.log(ui.values[ 0 ])
                                    var firstVal = 0;
                                     var secondVal = 0;
                                    if(ui.values[ 0 ] < 100){
                                        $( "#min_price" ).val(0);
                                           firstVal = 0;
                                    }else if(ui.values[ 0 ] < 200 ){
                                        $( "#min_price" ).val(100);
                                        firstVal = 100;
                                    }else if(ui.values[ 0 ] < 300 ){
                                        $( "#min_price" ).val(200);
                                        firstVal = 200;
                                    }else{
                                        $( "#min_price" ).val(300);
                                        firstVal = 300;
                                    }
                                    
                                    
                                    if(ui.values[ 1 ] <= 400){
                                        $( "#max_price" ).val(0);
                                        secondVal = 400;
                                        
                                    }else if(ui.values[ 1 ] <= 800 ){                                        
                                        $( "#max_price" ).val(800);
                                        secondVal = 800;
                                    }else{
                                        $( "#max_price" ).val(999);
                                        secondVal = 999;
                                    }
                                    //console.log("a", $( "#mySlider" ).slider( "values", [firstVal,secondVal] ));
                                    if($( "#mySlider" ).slider( "values", [firstVal,secondVal] )){
                                    $("#search_form").submit();
                                }
                               }
                              });
                              
                                
                              });
                           </script>
                           <div id="mySlider"></div>
                           <div class="slct1 col-md-12">
                               <?php $minPrice = array('0'=>'Min','100'=>'100','200'=>'200','300'=>'300');
                                     $maxPrice = array('400'=>'400','800'=>'800','999'=>'999');
                               ?>
                              {!! Form::select('min_price', $minPrice, $minArr, ['id'=>'min_price','class' => 'col-md-4 col-xs-4']) !!}

                              <p class="col-md-4 col-xs-4">To</p>
                              {!! Form::select('max_price', $maxPrice, $maxArr, ['id'=>'max_price','class' => 'col-md-4 col-xs-4']) !!}

                           </div>
                        </div>
                     </div>
                  </div>
                  
                   
                  
                  
                  <script> 
                     $(document).ready(function(){
                         $("#flip_price").click(function(){
                             $("#panel_price").slideToggle(300);
                         });
                     });
                  </script>
                  <script>
                     function myFunction_price() {
						 
                       var dots_price = document.getElementById("dots_price");
                      
                       var moreText_price = document.getElementById("panel_price");
                       var btnText_price = document.getElementById("flip_price");
                     
                       if (dots_price.style.display === "none") {
                         dots_price.style.display = "inline";
                         btnText_price.innerHTML = 'Price <i class="fa fa-angle-down" aria-hidden="true"></i>'; 
                         
                       } else {
                         dots_price.style.display = "none";
                         btnText_price.innerHTML = 'Price <i class="fa fa-angle-up" aria-hidden="true"></i>'; 
                        
                       }
                     }
                  </script>
                  <div class="col-md-12 product_ratingg">
                     <h2  onclick="myFunction_rating()" id="flip_rating">Customer Ratings <i class="fa fa-angle-down" aria-hidden="true"></i></h2>
                     <div class="p">
                        <span id="dots_rating"></span>
                        <div id="panel_rating">
                           <label class="container_checkbx ck1">4 & above
                               <input type="checkbox" name="rating[]" value="4" <?php if(in_array(4,$ratingArr)){?> checked="checked" <?php }?> />
<!--                               <input type="checkbox" checked="checked" value="4">-->
                           <span class="checkmark_checkbx"></span>
                           </label>
                           <label class="container_checkbx ck2">3 & above
                           <input type="checkbox" name="rating[]" value="3" <?php if(in_array(3,$ratingArr)){?> checked="checked" <?php }?> />
                           <span class="checkmark_checkbx"></span>
                           </label>
                           <label class="container_checkbx ck3">2 & above
                           <input type="checkbox" name="rating[]" value="2" <?php if(in_array(2,$ratingArr)){?> checked="checked" <?php }?> />
                           <span class="checkmark_checkbx"></span>
                           </label>
                           <label class="container_checkbx ck4">1 & above
                           <input type="checkbox" name="rating[]" value="1" <?php if(in_array(1,$ratingArr)){?> checked="checked" <?php }?> />
                           <span class="checkmark_checkbx"></span>
                           </label>
                        </div>
                     </div>
                  </div>
                  {!! Form::close() !!}
                  <script> 
                     $(document).ready(function(){
                         $("#flip_rating").click(function(){
                             $("#panel_rating").slideToggle(300);
                         });
                     });
                  </script>
                  <script>
                     function myFunction_rating() {
                       var dots_rating = document.getElementById("dots_rating");
                       var moreText_rating = document.getElementById("panel_rating");
                       var btnText_rating = document.getElementById("flip_rating");
                     
                       if (dots_rating.style.display === "none") {
                         dots_rating.style.display = "inline";
                         btnText_rating.innerHTML = 'Customer Ratings  <i class="fa fa-angle-down" aria-hidden="true"></i>'; 
                         
                       } else {
                         dots_rating.style.display = "none";
                         btnText_rating.innerHTML = 'Customer Ratings  <i class="fa fa-angle-up" aria-hidden="true"></i>'; 
                        
                       }
                     }
                  </script>
               </div>
               <div class="col-md-9 product_pgg">
                   @if(!$products2->isEmpty())
                  <div class="products-wrapper">
                     <div class="product-category-filter-wrap">
                        
                        @foreach($products2 as $key=> $product)
                        <?php $colorLists = CommonHelpers::getProductColor_image($product->color_id, $product->id);
                                     $images = CommonHelpers::getProductImage($product->id, $product->color_id); ?>
                               @if(!empty($colorLists) && !empty($images))
                        <div class="col-md-4 single-product-wrap men kid bagshoes">
                           <figure class="product-thumbnail">
                               
                               
                              <a href="{{URL::to('productDetail/'.$product->slug.'/'.$colorLists->slug)}}" class="d-block">
								
							  @if(!empty($images[0]))  
                              <img class="primary-thumb" src="{{PRODUCT_IMAGE_URL.$images[0]['image_name']}}" alt="Product"/>
                              @else
                              <img class="primary-thumb" src="{{asset('img/no-image.png')}}" alt="Product"/>
							 @endif
                              
                              @if(!empty($images[0]))
                              <img class="secondary-thumb" src="{{PRODUCT_IMAGE_URL.$images[0]['image_name']}}" alt="Product"/>
                              @else
                              <img class="secondary-thumb" src="{{asset('img/no-image.png')}}" alt="Product"/>
							 @endif
                              
                              
                              </a>
                              <figcaption class="product-hvr-content">
                                 <div class="btn-black btn-addToCart">
                                    <a id="myBtn_view" attId="{{$key}}" class="view_btn_class" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    
                                    
                                    <!--<a href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>-->
                                    
                                    
                                    
                                    @if(Auth::check())
                                     <?php $auth = LoginUser();
                                        $wishlist = CommonHelpers::wishlist_list($auth->id, $product->id, $product->color_id);
                                        ?>
                                    
                                    @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                                    <a name="wishlist_btn"  id="wishlist_btn_red" attrId="{{$product->id}}" attrColor ="{{$product->color_id}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @else 
                                    <a name="wishlist_btn" id="wishlist_btn" attrId="{{$product->id}}" attrColor ="{{$product->color_id}}" class="last_icn wishlist_btn wishBtnManageColor">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    @else
                                    <a name="wishlist_btn" title="Add to wishlist" class="last_icn wishlist_btn wishBtnManageColor login_wishlist">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                 </div>
                                  @if(isset($product->discount) && !empty($product->discount) && $product->discount != 0.00)
                                     <span class="product-badge">-{{$product->discount}}%</span>
                                    @else
                                            <span class="product-badge">New</span>
                                    @endif
                              </figcaption>
                           </figure>
                           <div class="product-details">
                              <h2 class="product-name">
                                  <a href="{{URL::to('productDetail/'.$product->slug.'/'.$colorLists->slug)}}">{{$product->product_title}}</a></h2>
                              <div class="product-prices">
                                <?php $discount = $product->discount;
                                    if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                                        $discount = ($discount/100)*$product->price_usd;
                                        $discount_price = $product->price_usd-$discount;
                                    }else{
                                       $discount = ($discount/100)*$product->price;
                                        $discount_price = $product->price-$discount; 
                                    }
                                ?>
                                 <span class="price">{!! CURRENCY !!}&nbsp;{{$discount_price}}</span>
                                  @if(isset($product->discount) && !empty($product->discount) && $product->discount != 0.00)
                                 <del class="oldPrice">{!! CURRENCY !!}&nbsp; 
                                     @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
                                     {{$product->price_usd}}
                                     @else
                                     {{$product->price}}
                                     @endif
                                 </del>
                                  @endif
                              </div>
                              
                            
                                        <?php 
                                        $reviews_sum = CommonHelpers::productReviews($product->id);
                                        $reviews_count = CommonHelpers::productReviewsCount($product->id);
                                        if(isset($reviews_count) && !empty($reviews_count)){
                                        $avg_rating = ($reviews_sum/$reviews_count);
                                        }else{
                                           $avg_rating = 0.00; 
                                        }
                                        $number = number_format($avg_rating,2);
                                        $n = $number;

                                        $whole = floor($n);      
                                        $fraction = $n - $whole;		
                                        ?>
                              
                              <div class="stars">
                                    @if(!empty($whole))  
                                     <?for($i=0; $i<$whole; $i++){?>
                                   <i class="fa fa-star f2" aria-hidden="true"></i> 
                                    <? } ?>
                                     <?if(($fraction>.50) ||($fraction==.50)){?>
                                    
                                    <i class="fa fa-star-half f2" aria-hidden="true"></i> 
                                    <? } ?>
                                   @endif
                              </div>
                           </div>
                        </div>
                        
                        
                         <!-- The Modal Product Image Popup-->
						<div id="myModal_view" attId="{{$key}}" class="modal_view rah{{$key}}">
						   <span class="close_view">&times;</span>
						   <!-- Modal content -->
						   <div class="modal-content_view">
							  <div class="modal-body_view">
								 <div class="slideshow_modal">
									 
									@foreach($images as $key1=>$val)
									<div class="mySlides_modal fade_modal rahImg{{$key}}">
									   <img src="{{PRODUCT_IMAGE_URL.$val['image_name']}}" style="width:100%">
									</div>
									@endforeach
									
									<a class="prev_modal" onclick="plusSlides_modal(-1)">&#10094;</a>
									<a class="next_modal" onclick="plusSlides_modal(1)">&#10095;</a>
								 </div>
								 <div style="text-align:center; margin-top: -25px;">
									<span class="dot_modal rahDots{{$key}}" onclick="currentSlide_modal(1)"></span> 
									
								 </div>
							  </div>
						   </div>
						</div>
                       @endif
                         @endforeach
                      
                        </div>
                  </div>
                  <div class="col-md-12 pg_ni">
                     
                     <ul>
						 
			{!! $products2->appends(Input::all('page'))->render() !!}
						 
                    <!-- <li><a href="#">Previous</a></li>
                     <li><a href="#">1</a></li>
                     <li><a href="#">2</a></li>
                     <li><a href="#">3</a></li>
                     <li><a href="#">...100</a></li>
                     <li><a href="#">Next</a></li>-->
                    </ul>
                  </div>
                @endif
               </div>
            </div>
         </div>
      </section>      
   <script>
var slideIndex = 1;

// Get the modal
var modal_view; 
var attId;

// Get the button that opens the modal
//~ var btn_view = document.getElementById("myBtn_view");

$('.view_btn_class').click(function($event){
	slideIndex = 1
	attId = $(this).attr("attId");
	console.log($(this).attr("attId"));
	modal_view = $(".rah"+attId)[0]
	modal_view.style.display = "block";
	showSlides_modal(slideIndex)
	
})

// Get the <span> element that closes the modal
var span_view = document.getElementsByClassName("close_view")[0];


function plusSlides_modal(n) {
  showSlides_modal(slideIndex += n);
}

function currentSlide_modal(n) {
  showSlides_modal(slideIndex = n);
}

function showSlides_modal(n) {
  var i;
  var slides_modal = document.getElementsByClassName("rahImg"+attId);
  var dots_modal = document.getElementsByClassName("rahDots"+attId);
  if (n > slides_modal.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides_modal.length}
  for (i = 0; i < slides_modal.length; i++) {
      slides_modal[i].style.display = "none";  
  }
  for (i = 0; i < dots_modal.length; i++) {
      dots_modal[i].className = dots_modal[i].className.replace(" active_modal", "");
  }
  slides_modal[slideIndex-1].style.display = "block";  
  dots_modal[slideIndex-1].className += " active";
}


// When the user clicks on <span> (x), close the modal
span_view.onclick = function() {
    modal_view.style.display = "none";
}

$(".close_view").click(function(){
	modal_view.style.display = "none";
})


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_view) {
        modal_view.style.display = "none";
    }
}
</script>  
<script> 
                     $(document).ready(function(){
                         $("#flip_size").click(function(){
                             $("#panel_size").slideToggle(300);
                         });
                     });
                  </script>
                  <script>
                     function myFunction_in() {
                       var dots_in = document.getElementById("dots_in");
                       var moreText_in = document.getElementById("panel_size");
                       var btnText_in = document.getElementById("flip_size");
                     
                       if (dots_in.style.display === "none") {
                         dots_in.style.display = "inline";
                         btnText_in.innerHTML = 'Size <i class="fa fa-angle-down" aria-hidden="true"></i>'; 
                         
                       } else {
                         dots_in.style.display = "none";
                         btnText_in.innerHTML = 'Size <i class="fa fa-angle-up" aria-hidden="true"></i>'; 
                        
                       }
                     }
                     
                     $("input[type=checkbox]").on("change", function() {
                        $("#search_form").submit(); 
                    });
                    $("#min_price").on("change", function() {
                        $("#search_form").submit(); 
                    });
                    $("#max_price").on("change", function() {
                        $("#search_form").submit(); 
                    });
                    
                   
                  </script>

<!--                  <script>
                  $("input[type=checkbox]").on("change", function() { 
                      //var data= $(this).is(':checked');
                      $("#search_form").submit();
    //var data = $("search_form").serialize();
    var data = $(this).val();
    console.log(123);
    alert(data);
    $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });
    $.ajax({
        url: '{{URL::to("/")}}/productCat/{{$slug}}/{{$subCatSlug}}/{{$subsubCatSlug}}', 
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: data,
        success: function(data){ 
            //alert(data) 
        }
    });
});
                  </script>-->
@stop
