<!-- Content Wrapper. Contains page content -->
@extends('layouts.home')
@section('content')

    <section class="dash_user">
<!--         <div class="container-fluid">
            <img src="{{asset('img/banner.png')}}">
         </div>-->
         <div class="container">
            <div class="row">
               @include('includes.frontend.sidebar')
               <div class="col-md-9 wishlist1">
                  <h4>Wishlist</h4>
                  @if(isset($wishlistProduts) && !empty($wishlistProduts))
                  @foreach($wishlistProduts as $key=>$wishlistProdut) 
                  <?php
                  $images = CommonHelpers::getProductImage($wishlistProdut->product_id, $wishlistProdut->color_id);
                  $colors = CommonHelpers::getColor($wishlistProdut->color_id);
                  //pr($colors);exit;
                  ?>
                  <div class="col-md-12 div_show">
                    <a href="{{URL::to('productDetail/'.$wishlistProdut->slug.'/'.$colors['0']['slug'])}}" class="img_links">
                        <img src="{{PRODUCT_IMAGE_URL.$images['0']['image_name']}}"></a>
                     <h3><a href="{{URL::to('productDetail/'.$wishlistProdut->slug.'/'.$colors['0']['slug'])}}">{{$wishlistProdut->product_title}}</a></h3>
                     <a class="remove_btn" href="javascript:void(0);" attrColor = "{{$wishlistProdut->color_id}}" attrId="{{$wishlistProdut->product_id}}" >Remove</a>
                     
					<?php   $discount = $wishlistProdut->discount;
                                            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
						$discount = ($discount/100)*$wishlistProdut->price_usd;
						$discount_price = $wishlistProdut->price_usd-$discount;
                                            }else{
                                                $discount = ($discount/100)*$wishlistProdut->price;
						$discount_price = $wishlistProdut->price-$discount;
                                            }
                                            
                                            $cart_discount = ($wishlistProdut->discount/100)*$wishlistProdut->price;
                                            $cart_price = $wishlistProdut->price - $cart_discount;
                                            $cart_usd_discount = ($wishlistProdut->discount/100)*$wishlistProdut->price_usd;
                                            $cart_usd_price = $wishlistProdut->price_usd - $cart_usd_discount;
					?>                    
                                        <p><span style="border-radius: 50%; padding:7px; background: {{ $colors['0']['color_picker'] }};"></span>&nbsp;&nbsp;
                         {!! CURRENCY !!}&nbsp;{{$discount_price}} <span>{!! CURRENCY !!}&nbsp;
                             @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
                             {{$wishlistProdut->price_usd}}
                             @else
                             {{$wishlistProdut->price}}
                             @endif
                         </span></p>
                                        <span class="size_error{{$wishlistProdut->id}}"></span>
                                         <span class="stock_error{{$wishlistProdut->id}}"></span>
                {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'panel_address','style'=>'display:block')) !!}  
                     
                       <?php 
                       $sizeLists = ['' => 'Select Size'] + CommonHelpers::getsizeProductList($wishlistProdut->product_id, $wishlistProdut->color_id);
                       ?>
                        <div class="form-group order_frm_slct wishlist_size">
                            {!! Form::select('size_id', $sizeLists, null, ['class'=>'size_ids'.$wishlistProdut->id]) !!}
                            <input type="hidden" value="{{$wishlistProdut->product_id}}" class="product_id{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$wishlistProdut->color_id}}" class="color_id{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$cart_discount}}" class="discount{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$cart_usd_discount}}" class="discount_usd{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$cart_price}}" class="price{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$cart_usd_price}}" class="price_usd{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$wishlistProdut->product_title}}" class="product_name{{$wishlistProdut->id}}" />
                            
                            <input type="hidden" value="{{$wishlistProdut->category_id}}" class="category_id{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$wishlistProdut->sub_category_id}}" class="sub_category_id{{$wishlistProdut->id}}" />
                            <input type="hidden" value="{{$wishlistProdut->sub_sub_category_id}}" class="sub_sub_category_id{{$wishlistProdut->id}}" />
                            
                            <button type="button" class="btn btn-default add_cart" datas = "{{$wishlistProdut->id}}">ADD TO BAG</button>
<!--                            <button type="submit" class="btn btn-default">Buy Now</button>-->
                            {!! Form::button('BUY NOW',['class'=>'btn btn-default by_now','datass'=>$wishlistProdut->id])!!}
                        </div>
                     {!! Form::close() !!}
                                        
                  </div>
                  @endforeach
                  @else
                  <div class="col-md-12"><h3>No items in wishlist</h3></div>
                  @endif
               </div>
            </div>
         </div>
      </section>
      
      
      
 <script>
 $(document).on("click",".add_cart",function() {
	
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });

        var id = $(this).attr("datas");
        productId = $('.product_id'+id).val();
        
        var qty = 1;      
        var size = $('.size_ids'+id).val();
        //alert(id);
        if(size == '') {
            $('.size_error'+id).text('Please Select Size.').css('color','red');
        }else{      
        var color_id = $('.color_id'+id).val();
        var price = $('.price'+id).val();
        var price_usd = $('.price_usd'+id).val();
        var product_name = $('.product_name'+id).val();
        var category_id = $('.category_id'+id).val();
        var sub_cat_id = $('.sub_category_id'+id).val();
        var sub_sub_cat_id = $('.sub_sub_category_id'+id).val();
        var discount = $('.discount'+id).val();
        var discount_usd = $('.discount_usd'+id).val();
        var html = [];
        //alert(price);
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
                wishlist: 1},
            success: function (msg) {                
                msg1 = JSON.parse(msg);
                console.log(msg1.message);
                console.log("adf", msg1.wishlist);
                $('.shopping-cart').html(msg1.count);
                //$('.product-cart').html(msg1.message);
                $('.size_error'+id).html(msg1.message).css('color','red');
                if(msg1.status == 'success'){
                   location.reload();                   
                }
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


       var id = $(this).attr("datass");
        productId = $('.product_id'+id).val();
        
        var qty = 1;      
        var size = $('.size_ids'+id).val();
        //alert(id);
        if(size == '') {
            $('.size_error'+id).text('Please Select Size.').css('color','red');
            return false;
        }else{      
        var color_id = $('.color_id'+id).val();
        var price = $('.price'+id).val();
        var price_usd = $('.price_usd'+id).val();
        var product_name = $('.product_name'+id).val();
        var category_id = $('.category_id'+id).val();
        var sub_cat_id = $('.sub_category_id'+id).val();
        var sub_sub_cat_id = $('.sub_sub_category_id'+id).val();
        var discount = $('.discount'+id).val();
        var discount_usd = $('.discount_usd'+id).val();
        
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
                price_usd: price_usd,
                product_name: product_name,
                cat_id: category_id,
                sub_cat_id: sub_cat_id,
                sub_sub_cat_id: sub_sub_cat_id,
                discount: discount,
                discount_usd: discount_usd},
            success: function (msg) {                
               msg1 = JSON.parse(msg);
                console.log(msg1.order);
                //$('.size_error'+id).html(msg1.message).css('color','red');
                //$('.shopping-cart').html(msg1.count);
                //$('.product-cart').html(msg1.message);
                //$('.size_error').text('');
               if(msg1.message != 'Only 0 quantity has left in stock'){
                setTimeout(function () {
                    @if (Auth::check())
                        window.location.assign("{{URL::to('ByNow')}}/"+msg1.order);
                    @else
                window.location.assign("{{URL::to('bynow')}}/"+msg1.order);
            @endif
                }, 2000);
            }else{
                console.log("size", msg1.message);
                $('.stock_error'+id).html('This product is out of stock.').css('color','red');
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
    
    
 $(document).on("click",".remove_btn",function() {
		$.ajaxSetup(
                {
                    headers:
                        {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                        }
                });
		
		productId = $(this).attr("attrId");
		var color_id = $(this).attr("attrColor");
		var html = [];
		$.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/removewishlist',
                    cache: false,
                    data: { product_id: productId,
                            color_id: color_id},
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        
                        $(".count_wish").html(msg1.count);
                        
						location.reload();
                    },
                    error: function (data) {
                    }
                });
	return false;
	
});
 </script>   
      
@stop
