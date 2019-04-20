 
<?php $__env->startSection('content'); ?>
<section class="card_page1">
         <div class="container">
            <div class="row card_row">
                <?php $total = 0;
                         $discount_price = 0;
                         $grand_total = 0;
                         $stock = "1";?>
                   <?php if(!$cart_details->isEmpty()): ?>
               <div class="col-md-8">
                    
                  <div class="col-md-12 dshow_nm">
                     <h2>My Bag</h2>
                     <span>(Item <?php echo e($countCart); ?>)</span>
                     <a href="javascript::void(0);" id="remove_all" datas-id = "removecart">Clear Cart</a>
                  </div>
                   
                  
                   <?php foreach($cart_details as $cart_detail): ?>
                   <?php 
                   if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                    $total = $total + $cart_detail->price_usd*$cart_detail->qty;
                    $discount_price = $discount_price + $cart_detail->discount_usd*$cart_detail->qty;
                    $grand_total = $total + Configure('CONFIG_SHIPPING_AMOUNT');
                   }else{
                    $total = $total + $cart_detail->price*$cart_detail->qty;
                    $discount_price = $discount_price + $cart_detail->discount*$cart_detail->qty;
                    $grand_total = $total + Configure('CONFIG_SHIPPING_AMOUNT');
                   }
                   ?>
                  <div class="col-md-12 list_show">
                      <?php $productsImage = CommonHelpers::getProductImage($cart_detail->product_id, $cart_detail->color_id); //pr($productsImage);exit;?>
                     <?php if(!empty($productsImage)): ?>
                      <img src="<?php echo e(PRODUCT_IMAGE_URL.$productsImage['0']['image_name']); ?>">
                      <?php else: ?>
                      <img src="<?php echo e(asset('img/no-image.png')); ?>">
                      <?php endif; ?>
                     <h3 ><?php echo e(ucfirst($cart_detail->product_name)); ?></h3>
                     <p class="price">
                         <br/>
                         <?php echo CURRENCY; ?>&nbsp;
                         <?php if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'): ?>
                         <?php echo e(number_format($cart_detail->price_usd*$cart_detail->qty+$cart_detail->discount_usd*$cart_detail->qty,2)); ?>

                         <?php else: ?>
                         <?php echo e(number_format($cart_detail->price*$cart_detail->qty+$cart_detail->discount*$cart_detail->qty,2)); ?>

                         <?php endif; ?>
                         <br/>
                         <?php if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'): ?>
                         <?php if(isset($cart_detail->discount_usd) && !empty($cart_detail->discount_usd) && $cart_detail->discount_usd != 0.00): ?>
                         <span><?php echo CURRENCY; ?>&nbsp;<?php echo e(number_format($cart_detail->discount_usd*$cart_detail->qty,2)); ?> </span>
                         
                         <br/><?php echo CURRENCY; ?>&nbsp; 
                         
                         <?php echo e(number_format($cart_detail->price_usd*$cart_detail->qty,2)); ?>

                         <?php endif; ?>
                         <?php else: ?>
                          <?php if(isset($cart_detail->discount) && !empty($cart_detail->discount) && $cart_detail->discount != 0.00): ?>
                         <span><?php echo CURRENCY; ?>&nbsp;<?php echo e(number_format($cart_detail->discount*$cart_detail->qty,2)); ?> </span><br/><?php echo CURRENCY; ?>&nbsp;
                         <?php echo e(number_format($cart_detail->price*$cart_detail->qty,2)); ?>

                         <?php endif; ?>
                         <?php endif; ?>
                         
                         <br>
                        
                     </p>
                     <?php 
                     
                     $check_cart_stock = CommonHelpers::check_cart_stock($cart_detail->product_id, $cart_detail->color_id, $cart_detail->size_id, $cart_detail->qty);?>
                     <?php if($check_cart_stock == 0): ?>
                     <?php $stock = "0";?>
                     <p>Out of stock</p>
                     <?php else: ?>
                     <p>in stock</p>
                     <?php endif; ?>
                     
                     
                     <form>
                         <input type="hidden" value="<?php echo e($cart_detail->id); ?>" class="cartIds" />
                         <?php //pr($qtyList);
                        $sizeLists = CommonHelpers::getsizeProductList($cart_detail->product_id,$cart_detail->color_id);
                        $colorLists = CommonHelpers::getProductColor($cart_detail->color_id);                    
                    ?>
                        <label>Size</label>                        
                        <?php echo Form::select('size_id', $sizeLists, $cart_detail->size_id, ['id'=>'size_ids','class' => '','datas' =>$cart_detail->id]); ?>

                        <label>Qty</label>
<!--                        <input type="number" value="<?php echo e($cart_detail->qty); ?>" min="1" name="quantity" id="quantity" />-->
<!--                        <input class="hhhh" type="number" min="1" name="qty" id="qty" value="<?php echo e($cart_detail->qty); ?>"/>-->
                        
                       <?php echo Form::select('qty', $qtyList, $cart_detail->qty, ['id'=>'qty_cart','class' => '',
                       'datas_qty' =>$cart_detail->id,'datas_pro' =>$cart_detail->product_id,'datas_size' =>$cart_detail->size_id,'datas_color' =>$cart_detail->color_id]); ?>

                       <p class="cart_message<?php echo e($cart_detail->id); ?> error"></p> 
                       <label>Color</label>
                        <span class="gola" style="background: <?php echo e($colorLists->color_picker); ?>;"></span>
                     </form>
                     <hr>
                     <div class="action11">     
                        <a href="<?php echo e(URL::to('/')); ?>" class="continue">Continue</a>  
                        <a href="javascript::void(0);" class="remove" id="remove_id" data-id = "<?php echo e($cart_detail->id); ?>">Remove</a>
                     </div>
                  </div>
                   <?php endforeach; ?>
                   
               </div>
               <div class="col-md-4">
                  <div class="col-md-12 order_lstt">
                     <h4>Order Summary</h4>
                     <div class="col-md-12">
                        <p class="lft">Bag Total<span>(Inculsive all taxes)</span></p>
                        <p class="ryt"><?php echo CURRENCY; ?>&nbsp; <?php echo e(number_format($total+$discount_price,2)); ?></p>
                     </div>
                      <?php if(isset($discount_price) && !empty($discount_price) && $discount_price != 0.00): ?>
                     <div class="col-md-12">
                        <p class="lft">Bag Discount</p>
                        <p class="ryt ryt1">- <?php echo CURRENCY; ?>&nbsp; <?php echo e(number_format($discount_price,2)); ?></p>
                     </div>
                      <?php endif; ?>
                     <div class="col-md-12">
                        <p class="lft">Shipping</p>
                        <?php if($grand_total != '0'): ?>
                        <p class="ryt"><?php echo CURRENCY; ?>&nbsp; <?php echo number_format(Configure('CONFIG_SHIPPING_AMOUNT'),2); ?></p>
                        <?php else: ?>
                        <p class="ryt"><?php echo CURRENCY; ?>&nbsp; 0</p>
                        <?php endif; ?>
                     </div>
                     <div class="col-md-12 ttl">
                        <p class="lft">Total</p>
                        <p class="ryt"><?php echo CURRENCY; ?>&nbsp; <?php echo e(number_format($grand_total,2)); ?></p>
                     </div>
                  </div>
                  <div class="col-md-12 checkot_link">
                      <?php if(Auth::check()): ?>
                        <a <?php if($stock == 0){?>href="javascript:void(0)" onclick="alert('This product quantity not available in stock')"<?php }else{?> href="<?php echo e(URL::to('checkout')); ?>" <?php }?> id="checkout_cart">Proceed to Chekcout</a>
                     <?php else: ?>
                     <a href="javascript::void(0)" class="login_wishlist">Proceed to Chekcout</a>
                     <br /><br /><br />
                     <a <?php if($stock == 0){?>href="javascript:void(0)" onclick="alert('This product quantity not available in stock')"<?php }else{?>href="<?php echo e(URL::to('guest_checkout')); ?>"<?php }?> id="checkout_cart">Continue as a guest</a>
                     <?php endif; ?>
                  </div>
               </div>
            <?php else: ?>
            <div class="no-cart">
                <h2>YOUR SHOPPING BAG IS EMPTY</h2>
                <h6>Don't let it stay empty. Add items from your wishlist</h6>
            </div>
                   <?php endif; ?>
            </div>
         </div>
      </section> 

<script>
    $(document).on("click", "#remove_id", function () {
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
        cartId = $(this).attr("data-id");
        var html = [];
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/cartDetail',
            cache: false,
            data: {
                cartId: cartId
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

    });
    
    
    $(document).on("click", "#remove_all", function () {
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
        cartId = $(this).attr("datas-id");
        var html = [];
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/cartDetail',
            cache: false,
            data: {
                cartremove: cartId
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

    });
    
    $(document.body).on('change',"#size_ids",function (e) {       
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
         var optVal= $(this).val();
         var cartIds = $(this).attr("datas");         
        var html = [];
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/cartDetail',
            cache: false,
            data: {
                size_id: optVal,
                cartIds: cartIds
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

});
   
  $(document.body).on('change',"#qty_cart",function (e) {       
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
         var optVal= $(this).val();
         var cartIds = $(this).attr("datas_qty"); 
         var product_id = $(this).attr("datas_pro");
         var size_id = $(this).attr("datas_size");
         var color_id = $(this).attr("datas_color");
        var html = [];
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/cartDetail',
            cache: false,
            data: {
                qty_id: optVal,
                qcartIds: cartIds,
                product_id: product_id,
                sizeId: size_id,
                color_id: color_id
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                $('.cart_message'+cartIds).html(msg1.message);
                $('#checkout_cart').attr('href', 'javascript:void(0)');
                $('#checkout_cart').attr('onclick', "alert('This product quantity not available in stock')");
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

});
 
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>