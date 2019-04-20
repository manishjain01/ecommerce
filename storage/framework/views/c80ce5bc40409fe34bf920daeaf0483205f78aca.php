 
<?php $__env->startSection('content'); ?>
<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec">
    <div class="container">
        <h2><?php echo e($pay_data->responce_msg.'  Your Order No is:- '.$pay_data->order_id.' And  Your Transaction Id is:- '.$pay_data->txn_id); ?></h2>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>