 
<?php $__env->startSection('content'); ?>
<style type="text/css">
.context-menu {
    cursor: context-menu;
    color:#16B594;
}

    a[disabled="disabled"] {
        pointer-events: none;
    }
</style>
<section class="order_page">
    <div class="container">
        <div class="row order_row">
            <div class="col-md-8">
<!--                <div class="col-md-12 hdhng_row">
                    <div class="col-md-4"><img src="<?php echo e(asset('img/image1.png')); ?>" class="img1"><img src="<?php echo e(asset('img/check-icon.png')); ?>" class="img2"><p>Email ID<p></div> 
                    <div class="col-md-6"><p> <p></div> 
                    <div class="col-md-2"></div> 
                </div>-->

                <div class="col-md-12 hdhng_row">
                    <div class="col-md-4"><img src="<?php echo e(asset('img/image1.png')); ?>" class="img1"><img src="<?php echo e(asset('img/check-icon.png')); ?>" class="img2"><p>Delivery Address<p></div> 
                    <div class="col-md-6"><p  class="del_address">
                            <?php if(isset($users[0]->address_1) && !empty($users[0]->address_1)): ?> 
                            <?php echo e($users[0]->address_1); ?><?php echo e(', '.$users[0]->address_2); ?> 
                            <?php endif; ?>
                        </p></div> 
                    <div class="col-md-2"><a href="javascript:void(0)"  id="flip_short_add" class="change_btn">Change</a></div> 
                </div>
                    <?php 
                    if(isset($users) && !empty($users)){
               if(empty($users[0]->address_1) || empty($users[0]->phone) || empty($city_name->city_name) || empty($state_name->state_name) || empty($users[0]->pincode)){
                  $isdisabled = "1"; 
               }else{
                   $isdisabled = "0";
               }
                    }
                ?>

                <div class="col-md-12 hdhng_row1 hng_ist" id="panel_short_add">
                    <div class="col-md-12">
                        <h2>Address</h2> 
                        <h4>Delivery Info</h4>
                        <div class="form-group" id="old_address" <?php  if(isset($isdisabled) && $isdisabled == 1){?>disabled="disabled" style="display:none;"<?php }?>>

                 
            <div class="frm_area">
                <p>Name:- <?php echo e(ucfirst($users[0]->first_name).' '.ucfirst($users[0]->last_name)); ?> <br/>
                   Email:- <?php echo e($users[0]->email); ?>

                   <?php if(!empty($users[0]->phone)): ?>
                   <br />Phone:- <?php echo e($users[0]->phone); ?>

                   <?php endif; ?>
                   <?php if(!empty($users[0]->address_1)): ?>
                    <br />Address:- <?php echo e($users[0]->address_1); ?>

                   <?php endif; ?>
                   <?php if(!empty($users[0]->address_2)): ?>
                    <br /><?php echo e($users[0]->address_2); ?>,
                   <?php endif; ?>                   
                   <?php if(!empty($city_name)): ?>
                    <br />City:- <?php echo e($city_name->city_name); ?>,
                    <?php endif; ?>
                    <?php if(!empty($state_name)): ?>
                    <br />State:- <?php echo e($state_name->state_name); ?>

                    <?php endif; ?>
                    <?php if(!empty($users[0]->pincode)): ?>
                    <br />Pincode:- <?php echo e($users[0]->pincode); ?>

                   <?php endif; ?>
                </p> 
                
            </div> 
<div class="form-group col-md-12" style="    padding-left: 0px;">
                                <label class="container_order_check">Check if use delivery address.
                                    <input type="checkbox" name="check_add" id="check_add" value="1">
                                    <span class="checkmark_order_check" style="border: 1px solid #ccc;"></span>
                                </label>
                            </div>               
<!--            <input type="checkbox" name="check_add" id="check_add" value="1">
                    check if delivery address same as account address.-->
                   </div>
                        
                     
                    <div class="col-md-8 col-sm-offset-4 add_other_addresss"> 
                                
                                <a href="javascript:void(0);" id="sohw_a">Add Other Address</a>
                                
                    </div> 
                        <br/>		
                        <?php echo Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'add_n','style'=>'display:none')); ?>  
			<?php echo csrf_field(); ?>

<p class="context-menu" id="back_address" <?php  if(isset($isdisabled) && $isdisabled == 1){?>disabled="disabled" style="display:none;"<?php }?>> Back to saved address </p>
                            
                            
                            <div class="form-group frm_frt frm_frt1">
                                <?php echo Form::text('first_name',null,['class'=>'form-control','placeholder'=>'FIrst Name', 'id' =>'first_name']); ?>

                                <div class="first_name_error error"><?php echo e($errors->first('first_name')); ?></div>
                            </div>
                            <div class="form-group frm_frt frm_frt2">
                                <?php echo Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Last Name', 'id' =>'last_name']); ?>

                                <div class="last_name_error error"><?php echo e($errors->first('last_name')); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <?php echo Form::text('email',null,['class'=>'form-control','placeholder'=>'Email', 'id' =>'email']); ?>

                                <div class="email_error error"><?php echo e($errors->first('email')); ?></div>
                                
                                
                            </div>
                            
                             <div class="form-group">
                                <?php echo Form::text('phone',null,['class'=>'form-control','placeholder'=>'Mobile (+91)', 'id' =>'phone']); ?>

                                <div class="phone_error error"><?php echo e($errors->first('phone')); ?></div>
                            </div>
                            
                            
                            <div class="form-group">
                                <?php echo Form::textarea('address_1',null,['class'=>'form-control','placeholder'=>'Address 1','id'=>'address_1']); ?>

                                <div class="address_1_error error"><?php echo e($errors->first('address_1')); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <?php echo Form::textarea('address_2',null,['class'=>'form-control','placeholder'=>'Address 2']); ?>

                                <div class="address_2_error error"><?php echo e($errors->first('address_2')); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <?php echo Form::text('pincode',null,['class'=>'form-control','placeholder'=>'Pincode', 'id' =>'pincode']); ?>

                                <div class="pincode_error error"><?php echo e($errors->first('pincode')); ?></div>
                            </div>
                            
<!--                            <input type="hidden" name="order_no" value="1000">-->
                            
                            
                            
                             <div class="form-group order_frm_slct order_frm_slct1 col-md-6">
                               <?php echo Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']); ?>

                               <div class="state_error error"><?php echo e($errors->first('state')); ?></div>
                            </div>
                            
                            <div class="form-group order_frm_slct order_frm_slct1 col-md-6">
                                <?php echo Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']); ?>

                                <div class="city_error error"><?php echo e($errors->first('city')); ?></div>
                              
                            </div>
                            
                            <div class="form-group col-md-12">
                                <p class="success-msg" style="color:#16B594;" id="success-msg"> </p>
                            </div>
                        
                          <?php echo Form::submit('Deliver to this Address',['class' => 'btn btn-default btn-submit','id' =>'new_address']); ?>

						<?php echo Form::close(); ?>

                        
                        
                        
                    </div>
                </div>
               
                <div class="col-md-12 hdhng_row">
                    <div class="col-md-4">
                        <img src="<?php echo e(asset('img/image1.png')); ?>" class="img1"><img src="<?php echo e(asset('img/check-icon.png')); ?>" class="img2"><p>Order Summery<p>
                    </div> 
                    <div class="col-md-6"><p><?php echo e($orders->item_total); ?> <span>item</span> Total <?php echo CURRENCY; ?>&nbsp;<?php echo e($orders->item_total_amount); ?><p>
                    </div> 
                    <div class="col-md-2"><a href="javascript:void(0)" disabled="disabled" id="flip_review" class="change_btn1">Change</a>
                    </div> 
                </div>
                <div class="col-md-12 oder_revw" id="panel_review" style="display: none;">
                    <div class="col-md-12 cl_rvw_sec">
                        <h2>Review Order</h2>
                        <h4>Order Summary</h4>
                       
                        <div class="col-md-12 oder_revw1">
                            <div class="col-md-3">
                                <?php $productsImage = CommonHelpers::getProductImage($order_details->product_id, $order_details->color_id); ?>
                                <img src="<?php echo e(PRODUCT_IMAGE_URL.$productsImage['0']['image_name']); ?>">
                            </div>
                            <div class="col-md-9 rv_cont">
                                <h3><?php echo e(ucfirst($order_details->product_name)); ?></h3>
                                <p class="price"> 
                                    <?php if(isset($orders->discount) && !empty($orders->discount) && $orders->discount != 0.00): ?>
                                    <?php echo CURRENCY; ?>&nbsp;
                                    <?php echo e($orders->item_total_amount + $orders->discount); ?>

                                    <br/>
                                    <span style="float: right; font-size: 16px;
    color: red;
    font-weight: 500;
    text-decoration: line-through;
    padding-right: 7px;"><?php echo CURRENCY; ?>&nbsp; <?php echo e($orders->discount); ?> </span>
                                    <?php endif; ?>
                                    <br/>
                                <?php echo CURRENCY; ?>&nbsp; <?php echo e($orders->item_total_amount); ?> <br>
                                </p>
                                
                                <?php $size = CommonHelpers::getSize($order_details->quantity); ?>
                               <p class="stock" data_productid = "<?php echo e($order_details->product_id); ?>" data_colorid = "<?php echo e($order_details->color_id); ?>" data_sizeid = "<?php echo e($order_details->size_id); ?>" data_qty = "<?php echo e($order_details->quantity); ?>">
                                    <span><b>Size</b>&nbsp; &nbsp;&nbsp;<?php echo e($size[0]['size']); ?></span> <span><b>Qty</b>&nbsp;&nbsp;&nbsp; <?php echo e($order_details->quantity); ?></span></p>
                                <p class="check_stock<?php echo e($order_details->product_id.$order_details->color_id.$order_details->size_id); ?> error"></p>
                            </div>
                        </div>
                       
                    </div>
                </div>
            <?php $grand_total = $orders->item_total_amount  + Configure('CONFIG_SHIPPING_AMOUNT');
            $total = $orders->item_total_amount;?>
                <div class="col-md-12 hdhng_row hdhng_row_lst">
                    <div class="col-md-4"><img src="<?php echo e(asset('img/image1.png')); ?>" class="img1"><img src="<?php echo e(asset('img/check-icon.png')); ?>" class="img2"><p>Make Payment<p></div> 
                    <div class="col-md-6"><p class="grand_total">1<span>&nbsp;Item</span> Total <?php echo CURRENCY; ?>&nbsp;<?php echo e($grand_total); ?></p>
                        <p class="total_amount" style="display:none;">1<span>&nbsp;Item</span> Total <?php echo CURRENCY; ?>&nbsp;<?php echo e($total); ?></p></div> 
                    <div class="col-md-2"><a href="javascript:void(0)" disabled="disabled" id="flip_pay"  class="change_btn2">Change</a></div> 
                </div>

                <div class="col-md-12" id="panel_pay" style="display: none;">
                    <div class="col-md-12 tab_payments"> 
                        <form action="<?php echo e(URL::to("/")); ?>/payment" method="post" id="payForm">
                            
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="tab col-md-4">
                                <?php if(CURRENCY == '<i class="fa fa-inr" aria-hidden="true"></i>'): ?>
                                <label class="container_payments">Paytm
                                    <input type="radio" name="pay_mode" value="paytm" class="pay_mode">
                                    <span class="checkmark_payments"></span>
                                </label>
                                <?php endif; ?>
                                <?php if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'): ?>
                                <label class="container_payments">Paypal
                                    <input type="radio" name="pay_mode" value="paypal" class="pay_mode">
                                    <span class="checkmark_payments"></span>
                                </label>
                                <?php endif; ?>
                                <label class="container_payments">PayU Money
                                    <input type="radio" name="pay_mode" value="payumoney" class="pay_mode">
                                    <span class="checkmark_payments"></span>
                                </label>
                                <label class="container_payments">COD
                                    <input type="radio" name="pay_mode" value="cod" class="pay_mode">
                                    <span class="checkmark_payments"></span>
                                </label>
                            </div>
                            <div class="col-md-8">
                                 <?php if($grand_total != '0.00'): ?>
                                <button type="submit" class="btn_amount" id="pay_now" />Pay Now</button>
                                <?php else: ?>
                                <button type="button" class="btn_amount" id="pay_now" onclick="alert('Item Not Found.');"  />Pay Now</button>
                                <?php endif; ?>
                                <input type="hidden" value="<?php echo e($order_no); ?>" name="order_no" />
                                
                                <input type="hidden" value="<?php echo e($grand_total); ?>" name="checkout_amount" class="grand_total"/>
                                <input type="hidden" value="<?php echo e($total); ?>" name="checkout_amount" class="total_amount" />
                                 <input type="hidden" value="<?php echo e(Configure('CONFIG_SHIPPING_AMOUNT')); ?>" name="shipping_amount" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12  order_lstt">
                    <h4>Order Summary</h4>
                    <div class="col-md-12"> <p class="lft">Bag Total<span>(Inculsive all taxes)</span></p>
                        <p class="ryt"><?php echo CURRENCY; ?>&nbsp;<?php echo e($orders->item_total_amount + $orders->discount); ?></p></div>
                        <?php if(isset($orders->discount) && !empty($orders->discount) && $orders->discount != 0.00): ?>
                    <div class="col-md-12"><p class="lft">Bag Discount</p>
                        <p class="ryt ryt1">- <?php echo CURRENCY; ?>&nbsp;<?php echo e($orders->discount); ?></p></div>
                        <?php endif; ?>
                    <div class="col-md-12" id="shipping_id">  <p class="lft">Shipping</p>
                        <?php if($grand_total != '0'): ?>
                        <p class="ryt"><?php echo CURRENCY; ?>&nbsp;<?php echo e(Configure('CONFIG_SHIPPING_AMOUNT')); ?></p>
                         <?php else: ?>
                         <p class="ryt"><?php echo CURRENCY; ?>&nbsp;0</p>
                         <?php endif; ?>
                    </div>
                    <div class="col-md-12 ttl">
                        <p class="lft">Total</p>
                        <p class="ryt grand_total"><?php echo CURRENCY; ?>&nbsp;<?php echo e($grand_total); ?></p>
                        <p class="ryt total_amount" style="display:none;"><?php echo CURRENCY; ?>&nbsp;<?php echo e($total); ?></p>
                    </div>
                </div>
            </div>

        </div> 
    </div>
</section>
<script>
    $(document).ready(function() {
            $('#check_add').change(function() {
                if(this.checked) {
                    var returnVal = confirm("Are you sure want to use delivery address.");
                    $(this).prop("checked", returnVal);
                }
                $('#check_add').val(this.checked); 
                if(this.checked){
                    $(".change_btn1").attr("disabled", false);
                    $(".change_btn2").attr("disabled", false);
                }else{
                  $(".change_btn1").attr("disabled", true);
                  $(".change_btn2").attr("disabled", true);
                }
            });
        });
    $(document).ready(function() {            
            $('.pay_mode').change(function() {
                var pay_val = $('input[name=pay_mode]:checked').val();
                if(pay_val == 'cod'){
                  $('#shipping_id').show();
                  $('.total_amount').css('display', 'none');
                    $('.grand_total').css('display', 'block');
                  
                }else{
                    var returnVal = alert("Congratulations! You don't have to pay shipping charges.");
                    //$(this).prop("checked", returnVal);
                    $('#shipping_id').hide();
                    $('.total_amount').css('display', 'block');
                    $('.grand_total').css('display', 'none');
                    
                }
                //alert(pay_val);
               
               
            });
        });
   $(document.body).on('click',"#pay_now",function (e) {
         var pay_mode = $('.pay_mode').is(":checked");
         if(pay_mode == false){
         alert("Please Select Payment Method.");
          return false;
     }else{
                
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });

        
        var html = [];
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/check_stock',
            cache: false,
            data: {},
            success: function (msg) { 
                console.log(msg);
                msg1 = JSON.parse(msg);
                var k = 0;
                 $.each(msg1.data, function (key, value) {
                        console.log(value);
                        if(value.stock == 0){
                            $('#panel_review').css('display', 'block');
                            $('.check_stock'+value.product_id+''+value.color_id+''+value.size_id).html(msg1.message);
                        //html.push('<li><a href="' + detail_url + '/' + value.slug + '/'+value.color_slug+'"><img src="' + url + value.image_name + '"><h4>' + value.product_title + '</h4> <span><?php echo CURRENCY; ?>&nbsp;<b>' + value.price + '</b></span></a></li>');
                         k++;
                        return false;
                        }
                    });
                    if(k == 0){
                    $('form#payForm').submit();
                    console.log(456);
                    return true;
                    }
                    console.log("as", k);
            },
            error: function (data) {
            }
        });
        
};

        return false;

});

    $(document).ready(function () {
        $("#flip_short_add").click(function () {
            $("#panel_short_add").slideDown("slow");
            $("#panel_review").slideUp("slow");
            $("#panel_pay").slideUp("slow");
        });
    });
    $(document).ready(function () {
        $("#sohw_a").click(function () {
            $('#add_n').show();
            $('#sohw_a').hide();
            $('#old_address').hide();
        });
    });
    
    
    $(document).ready(function () {
        $("#back_address").click(function () {
            $('#old_address').show();
            $('#add_n').hide();
            $('#sohw_a').show();
            $('#add_n')[0].reset();
            
        });
    });

    $(document).ready(function () {
        $("#flip_address").click(function () {
            $('#panel_address').show();
            $('#old_adress').hide();
            $('#flip_address').hide();
        });
    });

    $(document).ready(function () {
        $("#flip_review").click(function () {
            $("#panel_review").slideDown("slow");
            $("#panel_short_add").slideUp("slow");
            $("#panel_pay").slideUp("slow");
        });
    });

    $(document).ready(function () {
        $("#flip_pay").click(function () {
            $("#panel_pay").slideDown("slow");
            $("#panel_review").slideUp("slow");
            $("#panel_short_add").slideUp("slow");
        });
    });
    $(document).on("click",".change_btn",function() {


  $(".change_btn").closest( ".hdhng_row ").addClass('chng_css_row');

   $(".change_btn1").closest( ".hdhng_row ").removeClass('chng_css_row');
  $(".change_btn2").closest( ".hdhng_row ").removeClass('chng_css_row');
  
    event.stopPropagation();
    event.stopImmediatePropagation();
    //(... rest of your JS code)
});
$(document).on("click",".change_btn1",function() {

  $(".change_btn").closest( ".hdhng_row ").removeClass('chng_css_row');
  $(".change_btn2").closest( ".hdhng_row ").removeClass('chng_css_row');

  $(".change_btn1").closest( ".hdhng_row ").addClass('chng_css_row');
  
    event.stopPropagation();
    event.stopImmediatePropagation();
    //(... rest of your JS code)
});
$(document).on("click",".change_btn2",function() {

 $(".change_btn").closest( ".hdhng_row ").removeClass('chng_css_row');
  $(".change_btn1").closest( ".hdhng_row ").removeClass('chng_css_row');

  $(".change_btn2").closest( ".hdhng_row ").addClass('chng_css_row');
  
    event.stopPropagation();
    event.stopImmediatePropagation();
    //(... rest of your JS code)
});





$("#new_address").click(function() {	
	var first_name = $("#first_name").val();
	var last_name  = $("#last_name").val();
	var email      = $("#email").val();
	var phone 	   = $("#phone").val();
	var address_1  = $("#address_1").val();
	var address_2  = $("#address_2").val();
	var pincode    = $("#pincode").val();
	var city       = $("#city").val();
	var state      = $("#state").val();
	//alert(address_1);
	
	
	if ($.trim(first_name) == '') {
            $('.first_name_error').text('please enter first name');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text(''); 
            return false;
        }else if ($.trim(last_name) == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('please enter last name');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text(''); 
            return false;
        }else if ($.trim(email) == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('please enter email');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text('');   
            return false;
        }else if (!validateEmail($.trim(email))) {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('Invalid email format.');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text('');   
            return false;
        }else if ($.trim(phone) == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('please enter phone no.');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text(''); 
            return false;
        }else if (!phonenumber($.trim(phone))) {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('Invalid phone no. format');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text(''); 
            return false;
        }else if ($.trim(address_1) == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('please enter address');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text('');
            return false;
        }else if ($.trim(pincode) == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('please enter pincode');
            $('.state_error').text('');
            $('.city_error').text('');
            return false;
        }else if (!pincodenumber(pincode)) {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('pincode only numeric 6 digit format.');
            $('.state_error').text('');
            $('.city_error').text('');
            return false;
        }else if (state == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('please select state');
            $('.city_error').text('');
            return false;
        }else if (city == '') {
            $('.first_name_error').text('');
            $('.last_name_error').text('');
            $('.email_error').text('');
            $('.phone_error').text('');
            $('.address_1_error').text('');
            $('.pincode_error').text('');
            $('.state_error').text('');
            $('.city_error').text('please select city');
            return false;
        }
	else {
		
		$.ajax({
                    type: "POST",
                    url: '<?php echo e(URL::to("/")); ?>/newOrderAddress',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#add_n")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1); 
                        $('.first_name_error').text('');
                        $('.last_name_error').text('');
                        $('.email_error').text('');
                        $('.phone_error').text('');
                        $('.address_1_error').text('');
                        $('.pincode_error').text('');
                        $('.state_error').text('');
                        $('.city_error').text('');
                        
                        /*if(msg1.message == 'Delivery is not available at this location.'){
                            $('.pincode_error').html(msg1.message);
                        }else*/ if(msg1.message == 'Shipping Address Added Successfully'){
                            $('.success-msg').html(msg1.message);
                            $('.del_address').html(msg1.address);
                            $(".change_btn1").removeAttr("disabled");
                            $(".change_btn2").removeAttr("disabled");
                            $(".loading-cntant").css("display", "none");
                            $('#back_address').css("display", "none");
                       }
						//window.location.href = <?php echo e(URL::to('/')); ?>;					
                        
                    },
                    error: function (data) {
                    }
                });
	return false;
	
	}
});





$('select[id="state"]').on('change', function() {
	
    $.ajaxSetup(
    {
    headers:
    {
    'X-CSRF-Token': $('input[name="_token"]').val()
    }
    });
            var stateId = $(this).val();
            
           
            if (stateId) {
    $.ajax({
    url: '<?php echo SITE_URL; ?>'+'/'+'state_change/' + stateId,
            type: "POST",
            dataType: "json",
            success:function(data) {
				
				
            $('select[id="city"]').empty();
                    $.each(data, function(key, value) {
                    $('select[name="city"]').append('<option value="' + key + '">' + value + '</option>');
                    });
            }
    });
    } else{
    //$('select[name="city"]').empty();
    }
    }); 

function validateEmail(email) {
    
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
        return false;
    } else {
        return true;
    }
}

function phonenumber(inputtxt) {      
  //var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
   var phoneno =  /^\+?[0-9]*$/;
   if(inputtxt.length <= 7){
       
       return false
       
        } else {
  if((inputtxt.match(phoneno)))
        {
      return true;
        }
      else
        {
        //alert("message");
        return false;
        }
    }
}

function pincodenumber(inputtxt) {      
  //var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
   var phoneno =  /^\+?[0-9]*$/;
   if(inputtxt.length < 6){
       
       return false
       
        } else {
  if((inputtxt.match(phoneno)))
        {
      return true;
        }
      else
        {
        //alert("message");
        return false;
        }
    }
}



</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>