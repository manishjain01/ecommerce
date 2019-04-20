@extends('layouts.home') 
@section('content')

<style>
a.morelink {
	text-decoration:none;
	outline: none;
	font-size: 16px !important;

}
.morecontent span {
	display: none;
}
.comment {
	
	margin: 10px;
}
.hhhh{
    width: 10%;
    padding: 7px 5px;
    border: solid 1px #333;
    top: 0px;
    vertical-align: top;	
}
.btn-submit{
    padding: 10px 20px;
    color: #fff;
    background: #333;
    border: none;
    font-size: 16px;
    letter-spacing: 1px;
    border-radius: 3px;
    margin-top: 0%;
    margin-bottom: 5%;
    margin-left: auto;
    margin-right: auto;
    display: inline-block;
    
}
.radiowrapper {position:relative;}

.radiowrapper input {visibility:hidden; width:0;}

.radiowrapper input:checked + label {font-weight:bold; text-transform:uppercase;color:#38B861; border: 1px solid #38b861;}
</style>

<section class="detail_pagee">
    <div class="container">
        <div class="row">
            <div class="col-md-8 page_link"> 
                <a href="{{URL::to('/')}}">Home /</a>
                <a href="{{URL::to('productCat/'.$productDetail[0]['product_category']['slug'])}}">
                    {{ucfirst($productDetail[0]['product_category']['cat_name'])}} 
                    </a>
                    @if(!empty($productDetail[0]['product_subcategory']))
                    <a href="{{URL::to('productCat/'.$productDetail[0]['product_category']['slug'].'/'.$productDetail[0]['product_subcategory']['slug'])}}">
                    / {{ucfirst($productDetail[0]['product_subcategory']['cat_name'])}}
                     </a>
                    @endif
                    @if(!empty($productDetail[0]['product_sub_subcategory']))
                    <a href="{{URL::to('productCat/'.$productDetail[0]['product_category']['slug'].'/'.$productDetail[0]['product_subcategory']['slug'].'/'.$productDetail[0]['product_sub_subcategory']['slug'])}}">
                     / {{ucfirst($productDetail[0]['product_sub_subcategory']['cat_name'])}}
                     </a>
                    @endif
            </div>
            <div class="col-md-4 shar_vlu">
                <ul>
                    <li class="nd_cl">
<!--                        <p>Share</p>-->
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab20f13461ddb54"></script>
                        <div class="addthis_inline_share_toolbox_bxo5"></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row product_img_detail_row">
            <div class="col-md-6">
                <div class="single-product-thumb-wrap tab-style-left">
                    <!-- Product Thumbnail Large View -->
                    <div class="product-thumb-large-view">
                        <div class="product-thumb-carousel vertical-tab">
                            <?php $productsImage = CommonHelpers::getProductImage($product_id, $colorId); ?>
                            @foreach($productsImage as $key=>$value)  
                            <figure class="product-thumb-item">
                                <img src="{{PRODUCT_IMAGE_URL.$value['image_name']}}" alt="Single Product"/>
                            </figure>
                            @endforeach
                        </div>
                        <!-- Product Thumb Button  -->
                        <div class="product-thumb-btns">
                            <button class="btn-zoom-popup"><i class="fa fa-search-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <!-- Product Thumbnail Nav -->
                    <div class="vertical-tab-nav">                         
                        @foreach($productsImage as $key=>$value)                       
                            <figure class="product-thumb-item">
                                <img src="{{PRODUCT_IMAGE_URL.$value['image_name']}}" alt="Single Product"/>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--== Start Quick View Modal Wrapper ==-->
            <div class="modal" id="quickViewModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="dl-icon-close"></i></span>
                        </button>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Start Single Product Thumbnail -->
                                <div class="col-lg-5 col-md-6">
                                    <div class="single-product-thumb-wrap p-0 pb-sm-30 pb-md-30">
                                        <!-- Product Thumbnail Large View -->
                                        <div class="quciview-product-thumb-carousel">
                                            <figure class="product-thumb-item">
                                                <img src="{{asset('img/products/prod-1-1.jpg')}}" alt="Single Product"/>
                                            </figure>
                                            <figure class="product-thumb-item">
                                                <img src="{{asset('img/products/prod-1-2.jpg')}}" alt="Single Product"/>
                                            </figure>
                                            <figure class="product-thumb-item">
                                                <img src="{{asset('img/products/prod-1-1.jpg')}}" alt="Single Product"/>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product Thumbnail -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--== End Quick View Modal Wrapper ==-->
            <div class="col-md-6 pricde_detl">
                {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'asked_form')) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$productDetail[0]['product_title']}}" id="product_name" />
                        <input type="hidden" value="{{$productDetail[0]['category_id']}}" id="category_id" />
                        <input type="hidden" value="{{$productDetail[0]['sub_category_id']}}" id="sub_category_id" />
                        <input type="hidden" value="{{$productDetail[0]['sub_sub_category_id']}}" id="sub_sub_category_id" />
                <div class="col-md-12">
                    <h2>{{ucfirst($productDetail[0]['product_title'])}}</h2>
                   
                   
                    <?php if($check_stock == 0){ //echo "ad"; ?>
                    <span class="stock" >Out Of Stock</span>
                    
                    <?php }?>
                    
                    <?php $discount = $productDetail[0]['discount'];
                    if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                    $discount = ($discount/100)*$productDetail[0]['price_usd'];
                    $discount_price = $productDetail[0]['price_usd']-$discount;                    
                    }else{
                    $discount = ($discount/100)*$productDetail[0]['price'];
                    $discount_price = $productDetail[0]['price']-$discount;
                    }
                    
                    $cart_discount = ($productDetail[0]['discount']/100)*$productDetail[0]['price'];
                    $cart_price = $productDetail[0]['price'] - $cart_discount;
                    $cart_usd_discount = ($productDetail[0]['discount']/100)*$productDetail[0]['price_usd'];
                    $cart_usd_price = $productDetail[0]['price_usd'] - $cart_usd_discount;
                    ?>
                    <div class="shar_vlu">
                     <ul class="">
                    <li>

                        <?php
                        $reviews_sum = CommonHelpers::productReviews($productDetail[0]['id']);
                        $reviews_count = CommonHelpers::productReviewsCount($productDetail[0]['id']);
                        if (isset($reviews_count) && !empty($reviews_count)) {
                            $avg_rating = ($reviews_sum / $reviews_count);
                        } else {
                            $avg_rating = 0.00;
                        }
                        $number = number_format($avg_rating, 2);
                        $n = $number;

                        $whole = floor($n);
                        $fraction = $n - $whole;
                        ?>

                        <a href="javascript:void(0)" id="review_scroll">
                            <?for($i=0; $i<$whole; $i++){?>
                            <i class="fa fa-star f2" aria-hidden="true"></i> 
                            <? } ?>
                            <?if(($fraction>.50) ||($fraction==.50)){?>
                            <i class="fa fa-star-half f2" aria-hidden="true"></i> 
                            <? } ?>
                            <span>Review</span> {{$reviews_count}}
                        </a>
                    </li>
                </ul>
                </div>
                    @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')                    
                    <input type="hidden" value="{{$cart_usd_discount}}" id="discount" />
                    <input type="hidden" name="price_usd" value="{{$cart_usd_price}}" id="price"/>
                    @else
                    <input type="hidden" value="{{$cart_discount}}" id="discount" />
                    <input type="hidden" name="price" value="{{$cart_price}}" id="price"/>
                    @endif
                    
                    
                    
                    
                    <input type="hidden" name="color_id" value="{{$colorId}}" id="color_id"/>
                    
                    <input type="hidden" value="{{$cart_usd_discount}}" id="discount_usd_cart" />
                    <input type="hidden" value="{{$cart_usd_price}}" id="price_usd_cart"/>
                    <input type="hidden" value="{{$cart_discount}}" id="discount_cart" />
                    <input type="hidden" name="price" value="{{$cart_price}}" id="price_cart"/>
                    
                    <p> 
                        {!! CURRENCY !!}&nbsp;{{$discount_price}} 
                        @if(isset($discount) && !empty($discount) && $discount != 0.00)
                            <b>
                            {!! CURRENCY !!}&nbsp;
                            @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
                            {{number_format($productDetail[0]['price_usd'], 2)}}
                            @else
                            {{number_format($productDetail[0]['price'], 2)}}
                            @endif
                            </b>
                        @endif
                    </p>
                </div>
                <div class="col-md-12 size_gg">
                    <h4>Size</h4>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#sizeModal" >Size Guide</a>
                    <ul> 
                        @foreach($productDetail[0]['product_color'] as $sizes)
                        @if($sizes['color_id'] == $colorId)
                        <?php $size = CommonHelpers::getSize($sizes['size_id']); 
                        ?>
                        @if($sizes['quantity'] == 0)
                        <li>
                            <a href="javascript::void(0);" >
                                <strike>{{$size[0]['size']}}</strike>
                            </a>
                        </li>
                        @else                        
                        <div class="radiowrapper">
                        <input type="radio" class="size_ids" value="{{$size[0]['id']}}" id="size{{$size[0]['id']}}" name="size" />
                        <label for="size{{$size[0]['id']}}">{{$size[0]['size']}}</label>
                        </div>
                        
                       <!-- <li for = "size{{$size[0]['id']}}">
                            <a href="javascript::void(0)"  class="sizeids" data-ids = "{{$size[0]['id']}}">
                                {{$size[0]['size']}}
                            </a>
                        </li>-->
                        @endif
                        @endif
                        @endforeach
                        
                        
                    </ul>
                </div>
                 <div class="size_error"></div>
                <div class="col-md-12 color_gg">
                    <h4>Color</h4>
                    <?php $ss = array_unique(array_column($productDetail[0]['product_color'], 'color_id'));
                    //pr(array_intersect_key($productDetail[0]['product_color'], $ss));?>
                    @foreach(array_intersect_key($productDetail[0]['product_color'], $ss) as $color)
                    <?php 
                    $colorLists = CommonHelpers::getProductColor_image($color['color_id'],$productDetail[0]['id']); 
                    //pr($colorLists);
                    ?>
                    @if(!empty($colorLists))
                    @if($colorId == $colorLists->color_id)
                        <span  class="" style="background: {{ $colorLists->color_picker }}; border: 1px solid;"></span>
                    @else
                        <span onClick="location.href = '{{WEBSITE_URL}}productDetail/{{ $slug }}/{{ strtolower($colorLists->slug)}}';" class="" style="background: {{ $colorLists->color_picker }}"></span>
                    @endif
                    @endif
                    @endforeach
                    
                </div>
                <div class="col-md-12 qty">
                    <h4>Qty</h4>
                    <input class="hhhh" type="number" min="1" name="qty" id="qty" value="1"/>
                    @if(Auth::check())
                    <?php
                    $auth = LoginUser();
                    $wishlist = CommonHelpers::wishlist_list($auth->id, $productDetail[0]['id'], $colorId);
                    ?>
                    
                    @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                    <a href="javascript::void(0);" attrId="{{$productDetail[0]['id']}}" attrColor ="{{$colorId}}" class="wish_deail wishBtnManageColor wishlist_btn_red wishlist-btn-color">
                        <i class="fa fa-heart icon-fontaweson" aria-hidden="true"></i>
                    </a>
                    @else
                    <a href="javascript::void(0);" attrId="{{$productDetail[0]['id']}}" attrColor ="{{$colorId}}" class="wish_deail wishlist_btn wishBtnManageColor" style="color:black;">
                        <i class="fa fa-heart icon-fontaweson" aria-hidden="true"></i>
                    </a>
                    @endif
                    @else
                    <a name="wishlist_btn"  title="Add to wishlist" class="wish_deail wishlist_btn wishBtnManageColor login_wishlist">
                    <i class="fa fa-heart icon-fontaweson" aria-hidden="true"></i>
                    </a>
                    @endif                    
                </div>
                 
                <div class="col-md-12 add_crd">
                    <span class="product-cart"></span><br/>
                    <a href = "javascript:void(0);" style="margin-top:15px;">
                        {!! Form::button('BUY NOW',['class'=>'by_now','attrId'=>$productDetail[0]['id']])!!}
                        </a>
                    <a href = "javascript:void(0);" >
                        {!! Form::button('ADD TO CART',['class'=>'cart_btn cart_btn','attrId'=>$productDetail[0]['id']])!!}
                    </a>
<!--                    <a href="javascript::void(0);" class="cart_btn cart_btn" attrId="{{$productDetail[0]['id']}}">ADD TO CART</a>-->
                </div>
                {!! Form::close() !!}
                <div class="col-md-12 promo_code">
                    <h4>Product Availability</h4>
                    
                    {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'pincode_form')) !!}
                        <input type="text" name="pincode" id="pincode" placeholder="Enter Pincode">
                        
                        <button type="submit" id="check">Check</button>
                    {!! Form::close() !!}
                     
                </div>
               <span class="success-msg1" style='color:#38B861; margin-left:15px;'></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pro_detail_desc">
                <h2>Product Details</h2>
                <p>{{strip_tags($productDetail[0]['product_description'])}}</p>
            </div>
        </div>
        <div class="row detal_tabs">
            <div class="col-xs-12 ">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">DESCRIPTION</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">SIZE & FIT</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">DELIVERY</a>
                        <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">RETURN POLICY</a>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active in" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" >
                        <table>
                            <tr>
                                <td>Size:</td>
                                <td>
                                    <?php $ss = array_unique(array_column($productDetail[0]['product_color'], 'size_id'));?>
                    @foreach(array_intersect_key($productDetail[0]['product_color'], $ss) as $key=>$value)
                        <?php $size = CommonHelpers::getSize($value['size_id']); ?>
                                    {{$size[0]['size']}},
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Color:</td>
                                <td>
                                    <?php $sss = array_unique(array_column($productDetail[0]['product_color'], 'color_id'));
                ?>
                    @foreach(array_intersect_key($productDetail[0]['product_color'], $sss) as $key=>$value)
                    
                                   
                                    <?php //pr($value);
                                    $color = CommonHelpers::getColor($value['color_id']);
                                    ?>
                                    {{ucfirst($color[0]['color_name'])}},
                                    @endforeach
                                </td>
                            </tr>

                            @if($productDetail[0]['neckline'])
                            <tr>
                                <td>NeckLine:</td>
                                <td>{{$productDetail[0]['neckline']}}</td>
                            </tr>
                            @endif

                            @if($productDetail[0]['fabric'])
                            <tr>
                                <td>Fabric:</td>
                                <td>{{$productDetail[0]['fabric']}}</td>
                            </tr>
                            @endif


                            @if($productDetail[0]['season'])
                            <tr>
                                <td>Season:</td>
                                <td>{{$productDetail[0]['season']}}</td>
                            </tr>
                            @endif


                            @if($productDetail[0]['occasion'])
                            <tr>
                                <td>Occasion:</td>
                                <td>{{$productDetail[0]['occasion']}}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table>
                            <tr>
                                <td>35" - 36"</td>
                                <td>S</td>
                            </tr>
                            <tr>
                                <td>37" - 38"</td>
                                <td>M</td>
                            </tr>
                            <tr>
                                <td>39" - 40"</td>
                                <td>L</td>
                            </tr>
                            <tr>
                                <td>41" - 42"</td>
                                <td>XL</td>
                            </tr>
                            <tr>
                                <td>43" - 44"</td>
                                <td>2XL</td>
                            </tr>
                            <tr>
                                <td>45" - 46"</td>
                                <td>3XL</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    </div>
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    </div>
                </div>
            </div>
        </div>
        
        
        @if(isset($relatedProducts)  && !empty($relatedProducts))
        <div class="row slider_product">
            <h2>Similar Products</h2>
            <div id="carouselPlus" class="carousel slide multi-carousel" data-ride="carousel">
                <div class="carousel-inner">

                    @foreach($relatedProducts as $key=>$relatedProduct)
                    <?php $colorLists = CommonHelpers::getProductColor($relatedProduct['product_image'][0]['color_id']);?>
                    <div class="carousel-grid col-lg-3 col-md-4 col-sm-12">
                        <a href="{{URL::to('productDetail/'.$relatedProduct['slug'].'/'.$colorLists->slug)}}"><img class="d-block w-100" src="{{PRODUCT_IMAGE_URL.$relatedProduct['product_image'][0]['image_name']}}" alt="First slide"></a>
                        <div class="nm_po">
                            <a href="{{URL::to('productDetail/'.$relatedProduct['slug'].'/'.$colorLists->slug)}}"><h4>{{$relatedProduct['product_title']}}</h4></a>
                            <?  $discount = $relatedProduct['discount'];
                            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                            $discount = ($discount/100)*$relatedProduct['price_usd'];
                            $discount_price = $relatedProduct['price_usd']-$discount;
                            }else{
                            $discount = ($discount/100)*$relatedProduct['price'];
                            $discount_price = $relatedProduct['price']-$discount;
                            }
                            ?>

                            <p>{!! CURRENCY !!}&nbsp;{{$discount_price}}  <b>
                                    {!! CURRENCY !!}&nbsp;
                                    @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
                                    {{$relatedProduct['price_usd']}}
                                    @else
                                    {{$relatedProduct['price']}}
                                    @endif
                                </b></p>
                            <?php
                            $reviews_sum = CommonHelpers::productReviews($relatedProduct['id']);
                            $reviews_count = CommonHelpers::productReviewsCount($relatedProduct['id']);
                             if(isset($reviews_count) && !empty($reviews_count)){
                            $avg_rating = ($reviews_sum / $reviews_count);
                             }else{
                                    $avg_rating = 0.00; 
                                 }

                            $number = number_format($avg_rating, 2);
                            $n = $number;

                            $whole = floor($n);
                            $fraction = $n - $whole;
                            ?>

                            <a href="javascript:void(0)">
                                <?for($i=0; $i<$whole; $i++){?>
					<i class="fa fa-star f2" aria-hidden="true"></i> 
                                <? } ?>
                                <?if(($fraction>.50) ||($fraction==.50)){?>
					<i class="fa fa-star-half f2" aria-hidden="true"></i> 
                                <? } ?>
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#carouselPlus" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselPlus" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                    <span class="sr-only">Next</span>
                </a>      
            </div>
        </div>
        @endif
        
        
        
        
        <div id="lg" class="d-none d-lg-block"></div>
        <div id="md" class="d-none d-md-block d-lg-none"></div>
        <div id="sm" class="d-none d-sm-block d-md-none"></div>
        <script type="text/javascript">
            var $origin = $("#carouselPlus .carousel-inner").prop("outerHTML");
            function multiCarousel() {
                if ($("#lg").is(":visible")) {
                    do {
                        $("#carouselPlus .carousel-inner").children(".carousel-grid:lt(4)").wrapAll("<div class=\"carousel-item\"><div class=\"row\"></div></div>");
                        $("#carouselPlus .carousel-inner .carousel-item:first").addClass("active");
                    } while ($("#carouselPlus .carousel-inner").children(".carousel-grid").length);
                } else if ($("#md").is(":visible")) {
                    do {
                        $("#carouselPlus .carousel-inner").children(".carousel-grid:lt(3)").wrapAll("<div class=\"carousel-item\"><div class=\"row\"></div></div>");
                        $("#carouselPlus .carousel-inner .carousel-item:first").addClass("active");
                    } while ($("#carouselPlus .carousel-inner").children(".carousel-grid").length);
                } else {
                    do {
                        $("#carouselPlus .carousel-inner").children(".carousel-grid:lt(1)").wrapAll("<div class=\"carousel-item\"><div class=\"row\"></div></div>");
                        $("#carouselPlus .carousel-inner .carousel-item:first").addClass("active");
                    } while ($("#carouselPlus .carousel-inner").children(".carousel-grid").length);
                }
            }
            $(window).on("load resize", function () {
                $.when(
                        $("#carouselPlus .carousel-inner").replaceWith($origin),
                        multiCarousel()
                        ).done(function () {
                    $(".multi-carousel").animate({opacity: "1"}, 1000);
                });
            });

        </script>
        <div class="row review_rating_row">
            <div class="col-md-12">
                <h2>Reviews and Rating <i class="fa fa-star f1" aria-hidden="true"></i></h2>
            </div>
            <div class="col-md-12">
                <ul>
					@if(isset($productReviews) && !empty($productReviews))
					@foreach($productReviews as $key=>$productReview)
                    <li>
						<div class="col-md-1 col-xs-2">
						@if(isset($productReview->profile_img) && !empty($productReview->profile_img))
                                                    @if(substr($productReview->profile_img, 0, 4) == 'http')
                                                        <img src="{{$productReview->profile_img}}">
                                                    @else 
                                                        <img src="{{USER_IMAGE_URL.$productReview->profile_img}}">
                                                    @endif    
						@else
                                                <img src="{{asset('img/user.png')}}"> 
                                                @endif
                        </div>
                        
                       <div class="col-md-11 col-xs-10">
                        <h4>{{$productReview->first_name}} {{$productReview->last_name}}</h4>
                        <a href="javascript:void(0);">
                            <?for($i=1; $i <= $productReview->rating; $i++){?>
								<i class="fa fa-star f2" aria-hidden="true"></i> 
							<? } ?>
                        </a>
                       <p class="comment more"><?=$productReview->comment?></p>
				</div> 
                    </li>
                    @endforeach
                    @endif
                </ul>
                @if(isset($productReview) && !empty($productReview))
                <div class="col-md-12 view_all">
                    <a href="{{URL::to('allReviews/'.$productDetail[0]['id'].'/'.$productDetail[0]['slug'])}}">View all</a></div>
                @endif
            </div>
            <div class="col-md-12 review_write">
                @if(Auth::check())
                <a href="javascript:void(0)" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                    Write Your Review
                </a>                
                @else
                <a href="javascript:void(0)" class="btn btn-info btn-lg login_wishlist">
                    Write Your Review
                </a>
                @endif
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
	var showChar = 100;
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.more').each(function() {
		var content = $(this).html();
		if(content.length > showChar) {
			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);
			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
			$(this).html(html);
		}
	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
});

</script>


 <!-- Modal -->
<div class="modal fade review_write_popup" id="myModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Review & Rating</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
          
         <div class="modal-body">
            <div class="stars">
				<p class="success-msg login-error" style="color:green;"></p>
              {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'review_form')) !!}
                  <div class="form-group str_po">
                     <label>Rating:</label>
                     <input class="star star-5" id="star-5" type="radio" value="5" name="rating"/>
                     <label class="star star-5" for="star-5"></label>
                     <input class="star star-4" id="star-4" type="radio" value="4" name="rating"/>
                     <label class="star star-4" for="star-4"></label>
                     <input class="star star-3" id="star-3" type="radio" value="3" name="rating"/>
                     <label class="star star-3" for="star-3"></label>
                     <input class="star star-2" id="star-2" type="radio" value="2"name="rating"/>
                     <label class="star star-2" for="star-2"></label>
                     <input class="star star-1" id="star-1" type="radio" value="1" name="rating"/>
                     <label class="star star-1" for="star-1"></label>
                  </div>          
                  @if(Auth::check())
                  <input type="hidden" class="inputText" value="{{$auth->id}}" name="user_id"/>
                  @endif
                  <input type="hidden" class="inputText" value="{{$productDetail[0]['id']}}" name="product_id"/>
                  <div class="form-group rvw">
                     <label for="comment">Review:</label>
                     {!! Form::textarea('comment',null,['class'=>'form-control','placeholder'=>'Comment','id' =>'comment']) !!}
                  </div>
                  {!! Form::submit('Submit',['class' => 'btn btn-default btn-submit','id' =>'review'])!!}
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
</div>



<!-------Size Modal----------->
<div class="modal fade review_write_popup" id="sizeModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Size Guide</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
          
        <div class="modal-body">
		<div class="bsg_sizeinfo">
        <table class="bsg_table bsg_portrait" style="width:100%;margin:0 auto;border-collapse:collapse;border-bottom:1px solid #eee;">
            <tbody>
				<tr>
				  <td>If your body chest<br>measures</td>
				  <td>Then you should<br>go for</td>
				</tr>
				<tr>
					<td>35" - 36"</td>
					<td>S</td>
				</tr>
				<tr>
					<td>37" - 38"</td>
					<td>M</td>
				</tr>
				<tr>
					<td>39" - 40"</td>
					<td>L</td>
				</tr>
				<tr>
					<td>41" - 42"</td>
					<td>XL</td>
				</tr>
				<tr>
					<td>43" - 44"</td>
					<td>2XL</td>
				</tr>
				<tr>
					<td>45" - 46"</td>
					<td>3XL</td>
				</tr>
			</tbody>
		</table>
      </div>
         </div>
      </div>
   </div>
</div>


<!-------Size Modal End----------->



<script>
$("#review").click(function() {
		
	var comment = $("#comment").val();
	var rating = $("input[name='rating']:checked").val();
	
	/*if (comment == '' || rating == '') {
	alert("Please fill all fields...!!!!");
	return false;
	}
	else {*/
		$.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/review_post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#review_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        $('.success').addClass('su').html(msg1.message);
                        $('.success-msg').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
                        if(msg1.message=='Review submitted successfully'){
                            
							$("#review_form")[0].reset();
                                                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
						}
						//window.location.href = {{URL::to('/')}};
                    },
                    error: function (data) {
                    }
                });
	return false;
	
	//}
});

//==========Pincode Check===================//

$("#check").click(function() {
		
	var pincode = $("#pincode").val();
	if (pincode == '' ) {
	alert("Please enter pincode...!!!!");
	return false;
	}else if(pincode.length != 6){
		
	alert("Please enter correct pincode...!!!!");
	return false;
	} 
	else {
		
		$.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/pincode_post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#pincode_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        $('.success').addClass('su').html(msg1.message);
                        $('.success-msg1').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
						//window.location.href = {{URL::to('/')}};	
                    },
                    error: function (data) {
                    }
                });
	return false;
	}
});

    $(document).on("click", ".cart_btn", function () {
        var url = '{{PRODUCT_IMAGE_URL}}';
        var detail_url = '{{URL::to("productDetail")}}';
        
        var self = this;
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });


        productId = $(this).attr("attrId");
        var qty = $('#qty').val();
      
        var size = $('input[name=size]:checked').val();
        
        if(size == undefined) {
            $('.size_error').text('Please Select Size.').css('color','red');
        }else{      
        var color_id = $('#color_id').val();
        var price = $('#price_cart').val();
        var price_usd = $('#price_usd_cart').val();
        var product_name = $('#product_name').val();
        var category_id = $('#category_id').val();
        var sub_cat_id = $('#sub_category_id').val();
        var sub_sub_cat_id = $('#sub_sub_category_id').val();
        var discount = $('#discount_cart').val();
        var discount_usd = $('#discount_usd_cart').val();
       
        //var discount_usd = $('#discount_usd').val();
        //var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/addtocart',
            cache: false,
            data: {
                product_id: productId,
                qty: qty,
                size: size,
                color_id: color_id,
                price: price,
                price_usd: price_usd,
                product_name: product_name,
                cat_id: category_id,
                sub_cat_id: sub_cat_id,
                sub_sub_cat_id: sub_sub_cat_id,
                discount: discount,
                discount_usd: discount_usd,
                wishlist: false},
            success: function (msg) {                
                msg1 = JSON.parse(msg);
                console.log(msg1.message);
                if(msg1.message == 'Successfully added in cart'){
                $('.shopping-cart').html(msg1.count);
                $('.shopping-cart').removeAttr("style");
                
               
            }
                $('.product-cart').html(msg1.message);
                $('.product-cart').css('font-size','15px');
                $('.size_error').text('');
                //$('.cart_btn').text('ADDED TO CART');
                //$('.cart_btn').prop('disabled', true);
            },
            error: function (data) {
            }
        });
        return false;
};
    });
    
    
    $(document).on("click", ".by_now", function () { 
        var url = '{{PRODUCT_IMAGE_URL}}';
        var detail_url = '{{URL::to("productDetail")}}';
        
        var self = this;
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });


        productId = $(this).attr("attrId");
        var qty = $('#qty').val();
      
        var size = $('input[name=size]:checked').val();
        
        if(size == undefined) {
            $('.size_error').text('Please Select Size.').css('color','red');
        }else{      
        var color_id = $('#color_id').val();
        var price = $('#price').val();
        var product_name = $('#product_name').val();
        var category_id = $('#category_id').val();
        var sub_cat_id = $('#sub_category_id').val();
        var sub_sub_cat_id = $('#sub_sub_category_id').val();
        var discount = $('#discount').val();
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/by_now',
            cache: false,
            data: {
                product_id: productId,
                qty: qty,
                size: size,
                color_id: color_id,
                price: price,
                product_name: product_name,
                cat_id: category_id,
                sub_cat_id: sub_cat_id,
                sub_sub_cat_id: sub_sub_cat_id,
                discount: discount},
            success: function (msg) {                
               msg1 = JSON.parse(msg);
                console.log(msg1);
                //$('.shopping-cart').html(msg1.count);
                //$('.product-cart').html(msg1.message);
                //$('.size_error').text('');
               if(msg1.message == 'success'){
                setTimeout(function () {
                    @if (Auth::check())
                        window.location.assign("{{URL::to('ByNow')}}/"+msg1.order);
                    @else
                window.location.assign("{{URL::to('bynow')}}/"+msg1.order);
            @endif
                }, 2000);
            }else{
                $('.product-cart').html(msg1.message);
            }
                //$('.cart_btn').text('ADDED TO CART');
                //$('.cart_btn').prop('disabled', true);
            },
            error: function (data) {
            }
        });
        return false;
};
    });
    
    
    
</script>
    <script>
        $(document).ready(function (){
            $("#review_scroll").click(function (){
                $('html, body').animate({
                    scrollTop: $(".review_rating_row").offset().top
                }, 2000);
            });
        });
    </script>
    <style>
        .stock{
            color: red;
    font-size: 13px !important;
    padding: 1px 0px 4px 0px;
    margin-left: 3px;
        }
    </style>
@stop

