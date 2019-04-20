<?php $__env->startSection('content'); ?>  
<section class="dash_user ">
<!--         <div class="container-fluid">
            <img src="<?php echo e(asset('img/banner.png')); ?>">
         </div>-->
         <div class="container">
         <div class="row">
            <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="col-md-9 order_mng1">
               <h4>Order Managment</h4>
               <?php if(!$orderLists->isEmpty()): ?>
               <?php foreach($orderLists as $orderList): ?>
               <?php  $orders = CommonHelpers::user_orders($orderList->id);
               
               ?>
               
               <?php foreach($orderList->order_detail as $key=>$order): ?>
               <?php $productsImage = CommonHelpers::getProductImage($order->product_id, $order->color_id);
               $sizes = CommonHelpers::getSize($order->size_id);
               //pr($sizes);
               ?>
               <div class="col-md-12 div_show">
                   <?php if(!empty($productsImage['0']['image_name'])): ?>
                  <img src="<?php echo e(PRODUCT_IMAGE_URL.$productsImage['0']['image_name']); ?>">
                  <?php else: ?>
                  <img src="<?php echo e(asset('img/no-image.png')); ?>">
                  <?php endif; ?>
                  <h3>Order ID &nbsp;&nbsp;<b>#<?php echo e($order->order_no); ?></b> <span class="date_productss">Date <?php echo e(date('j F, Y', strtotime($order->created_at))); ?></span></h3>
                  <h3 class="pr_nm">Name &nbsp;&nbsp;<b><?php echo e($order->product_name); ?></b></h3>
                  <h3 class="pr_nm">
                      <span class="date_productss1">Gross Amount <b>Rs. <?php echo e(($order->discount*$order->quantity)+($order->unit_price*$order->quantity)); ?></b></span>
                      <span class="date_productss1">Discount <b>Rs. <?php echo e($order->discount*$order->quantity); ?></b></span>
                      <span class="date_productss1">Amount <b>Rs. <?php echo e($order->unit_price*$order->quantity); ?></b></span>
                  </h3>
                  <p><b>Size</b>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($sizes['0']['size']); ?>&nbsp;&nbsp;  |  <b>&nbsp;&nbsp;&nbsp;&nbsp;Qty</b>&nbsp;&nbsp; <?php echo e($order->quantity); ?></p>
<!--                  <p class="stts">Status</p>
                  <div class="wrapper1 col-md-12">
                     <div class="dot one"></div>
                     <div class="dot two"></div>
                     <div class="dot three"></div>
                     <div class="dot four"></div>
                     <div class="dot five"></div>
                     <div class="progress-bar first"></div>
                     <div class="message message-1">Pending</div>
                     <div class="message message-2">In Process</div>
                     <div class="message message-3">Shiped</div>
                     <div class="message message-4">Delivered</div>
                     <div class="message message-5">Cancelled</div>
                  </div>-->
<!--                  <p class="view_ordr"><a href="javascript::void(0);">View Order</a></p>-->
               </div>
               <?php endforeach; ?>
               <div class="col-md-12" style="text-align: center;">
                   <p><strong style="color:#489a11">Summary:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Payment Mode:&nbsp;&nbsp; <strong><?php echo e($orderList->pay_mode); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;Total Amount:&nbsp;&nbsp; <strong><?php echo e($orderList->item_total_amount); ?></strong>
                   &nbsp;&nbsp;&nbsp;&nbsp;Shipping Charge:&nbsp;&nbsp;<strong><?php echo e($orderList->shipping_amount); ?></strong>
                 &nbsp;&nbsp;&nbsp;&nbsp;Amount Paid:&nbsp;&nbsp;<strong><?php echo e(($orderList->shipping_amount)+($orderList->item_total_amount)); ?></strong></p>
               </div>
               <span style="border-bottom: 2px dotted #adadad; padding:5px; color:#fff; margin-bottom: 18px; line-height: 0; display: block;">.</span>
               <?php endforeach; ?>
               <div class="col-md-12 pg_ni order_listings">
                     
                   <ul>
               <?php echo $orderLists->appends(Input::all('page'))->render(); ?>

                   </ul>
               </div>
               <?php else: ?>
               
               <div>Order Not Found.</div>
               <?php endif; ?>
               
               
               
            </div>
         </div>
      </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>