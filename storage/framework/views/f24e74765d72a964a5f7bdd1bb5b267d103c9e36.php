<?php $__env->startSection('content'); ?>  

 <section class="dash_user">
<!--         <div class="container-fluid">
            <img src="<?php echo e(asset('img/banner.png')); ?>">
         </div>-->
         <div class="container">
            <div class="row">
               <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <div class="col-md-9 account_info1 info_displyy">
                  <h4>Dashboard</h4>
                  
					<div class="row">
						<div class="col-md-3 col-xs-3"><p>Name</p></div>
						<div class="col-md-7 col-xs-9"><p><?php echo e($user[0]->first_name); ?> <?php echo e($user[0]->last_name); ?></p></div>
						
					    <div class="col-md-2">
							<div class="img_profile_dash">
								<?php //echo $result = substr($user[0]->profile_img, 0, 4);?>
								<?php if(isset($user[0]->profile_img) &&!empty($user[0]->profile_img)): ?>
                                                                    <?php if(substr($user[0]->profile_img, 0, 4) == 'http'): ?>
                                                                        <img alt="" src="<?php echo e($user[0]->profile_img); ?>">
                                                                    <?php else: ?>
                                                                        <img alt="" src="<?php echo e(USER_IMAGE_URL.$user[0]->profile_img); ?>">
                                                                    <?php endif; ?>
								<?php else: ?>
								<img alt="" src="<?php echo e(asset('img/no-image.png')); ?>">
								<?php endif; ?>
							</div>
						</div>
					    
						<div class="col-md-3 col-xs-3"><p>Email</p></div>
						<div class="col-md-9 col-xs-9"><p><?php echo e($user[0]->email); ?></p></div>
						
						<div class="col-md-3 col-xs-3"><p>Mobile</p></div>
						<div class="col-md-9 col-xs-9"><p><?php echo e($user[0]->phone); ?></p></div>
						
						<div class="col-md-3 col-xs-3"><p>Address</p></div>
						<div class="col-md-9 col-xs-9"><p><?php echo e($user[0]->address_1.' '.$user[0]->address_2); ?>, 
                                                        <?php if(!empty($city->city_name)): ?>
                                                        <?php echo e($city->city_name); ?>,
                                                        <?php endif; ?>
                                                        <?php if(!empty($state->state_name)): ?>
                                                        <?php echo e($state->state_name); ?>,
                                                        <?php endif; ?>
                                                        <?php if(!empty($user[0]->pincode)): ?>
                                                        <?php echo e($user[0]->pincode); ?>

                                                        <?php endif; ?>
                                                    </p></div>
						
					</div>
					
					
               </div>
            </div>
         </div>
      </section>
     

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>