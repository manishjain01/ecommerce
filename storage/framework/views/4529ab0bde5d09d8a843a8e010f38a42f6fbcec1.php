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
        display: block;	
    }

</style>
<section class="dash_user">
    <!--         <div class="container-fluid">
                <img src="<?php echo e(asset('img/banner.png')); ?>">
             </div>-->
    <div class="container">
        <div class="row">
            <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="col-md-9 account_info1">
                <h4>Account Information</h4>

                <span class="msg1" style="color:#38B861;">
                    <?php if(Session::has('alert-sucess')): ?>
                    <?php echo Session::get('alert-sucess'); ?>

                    <?php endif; ?>
                    <?php if(Session::has('alert-error')): ?>
                    <?php echo Session::get('alert-error'); ?>

                    <?php endif; ?>
                </span>


                <?php echo Form::model($user,['route'=>['updateProfile',$user[0]->id],'files'=>true,'id' =>'edit_form','style'=>'display:block']); ?>

                <?php echo csrf_field(); ?>


                <div class="form-group">
                    <?php echo Form::text('email',$user[0]->email,['class'=>'form-control input-group-lg','placeholder'=>'Email','readonly']); ?>

                </div>

                <div class="form-group">
                    <?php echo Form::text('first_name',$user[0]->first_name,['class'=>'form-control input-group-lg','placeholder'=>'First Name']); ?>

                    <div class="error"><?php echo e($errors->first('first_name')); ?></div> 
                </div>
                 

                <div class="form-group">
                    <?php echo Form::text('last_name',$user[0]->last_name,['class'=>'form-control input-group-lg','placeholder'=>'Last Name']); ?>

                    <div class="error"><?php echo e($errors->first('last_name')); ?></div> 
                </div>
                 


                <div class="form-group">
                    <?php echo Form::text('phone',$user[0]->phone,['class'=>'form-control input-group-lg','placeholder'=>'Phone']); ?>

                    <div class="error"><?php echo e($errors->first('phone')); ?></div>
                </div>
                 



                <div class="form-group">
                    <div data-provides="fileupload" class="fileupload fileupload-new">
                        <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail">
                            <?php if(isset($user[0]->profile_img) && !empty($user[0]->profile_img)): ?> 
                            <?php if(substr($user[0]->profile_img, 0, 4) == 'http'): ?>
                            <img alt="" src="<?php echo e($user[0]->profile_img); ?>">
                            <?php else: ?>    
                            <img alt="" src="<?php echo e(USER_IMAGE_URL.$user[0]->profile_img); ?>">
                            <?php endif; ?>
                            <?php else: ?>
                            <img alt="" src="<?php echo e(asset('img/no-image.png')); ?>">   
                            <?php endif; ?>
                        </div>
                        <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"> </div>
                        <div> <span class="btn btn-alt btn-primary btn-file"> <span class="fileupload-new"> <i class="fa fa-paper-clip"></i> Select image </span> <span class="fileupload-exists"> <i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" name="profile_img" />
                            </span>
                            <label for="required" generated="true" class="error"></label>
                        </div>
                    </div>
                     <div class="error"><?php echo e($errors->first('profile_img')); ?></div>
                </div>

                 

                <?php echo Form::submit('Submit',['class' => 'btn btn-default btn-submit']); ?>



                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>