<?php $__env->startSection('content'); ?> 

<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec">
    <div class="container">
        <div class="row no-gutters">
           
            <h2><?php echo e($cmslist->title); ?></h2>
        </div>
        <?php echo $cmslist->description; ?>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>