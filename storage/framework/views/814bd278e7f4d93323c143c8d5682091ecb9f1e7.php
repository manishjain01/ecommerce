<!-- Content Wrapper. Contains page content -->


<?php $__env->startSection('content'); ?>  
<style>
.btn-submit{
    padding: 19px 35px;
    color: #fff;
    background: #333;
    border: none;
    font-size: 16px;
    letter-spacing: 1px;
    border-radius: 3px;
    margin-top: 5%;
    margin-bottom: 5%;
    margin-left: auto;
    margin-right: auto;
    display: inline-block;	
    
}

</style>
    
     <section class="dash_user">
<!--         <div class="container-fluid">
            <img src="<?php echo e(asset('img/banner.png')); ?>">
         </div>-->
         <div class="container">
            <div class="row">
                <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <div class="col-md-9 chng_pass1">
                  <h4>Change Password</h4>
					<?php echo Form::open(array('id'=>'education', 'method'=>'post','route'=>['update_password'])); ?>

					<?php echo csrf_field(); ?>

                     <?php if(isset($user->login_mode) && $user->login_mode == 'manual'){?>
                     <div class="form-group">
                        <?php echo Form::password('old_password',['class'=>'form-control','placeholder'=>'Old Password']); ?>

                        <div class="error"><?php echo e($errors->first('old_password')); ?></div>
                     </div>
                     <?php }?>                 
                     <div class="form-group">
                        <?php echo Form::password('new_password',['class'=>'form-control input-group-lg','placeholder'=>'New Password']); ?>

                         <div class="error"><?php echo e($errors->first('new_password')); ?></div>
                        
                     </div>
                     <div class="form-group">
                         <?php echo Form::password('confirm_password',['class'=>'form-control input-group-lg','placeholder'=>'Confirm New Password']); ?>

                         <div class="error"><?php echo e($errors->first('confirm_password')); ?></div>
                     </div>
                     <div class="form-group btn_chng">
                        <button type="button" class="btn btn-default chng_p" id="cancel_btn">Cancel</button>
                       
                        <?php echo Form::submit('Update',['class' => 'btn btn-default btn-submit']); ?>

                         
                        
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </section>
 <script>
 $("#cancel_btn").on('click', function(event){
	 
	window.location.href = '<?php echo e(URL::to("/")); ?>/myaccount';
    return false;
});
 </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>