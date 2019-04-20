<!-- Content Wrapper. Contains page content -->


<?php $__env->startSection('content'); ?>  

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        <?php echo $__env->make('includes.admin.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
             <div class="box-header with-border">
                <h3 class="pull-right">  
                    <?php echo Html::decode(Html::link(route('admin.users.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])); ?>

                </h3>
            </div>
            <?php echo Form::open(['route'=>'admin.users.store','files'=>true]); ?>  
            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.FIRST_NAME'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::text('first_name',null,['class'=>'form-control','placeholder'=>trans('admin.FIRST_NAME')]); ?>

                            <div class="error"><?php echo e($errors->first('first_name')); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.LAST_NAME'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group"><?php echo Form::text('last_name',null,['class'=>'form-control','placeholder'=>trans('admin.LAST_NAME')]); ?>

                            <div class="error"><?php echo e($errors->first('last_name')); ?></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.EMAIL'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::text('email',null,['class'=>'form-control','placeholder'=>trans('admin.EMAIL')]); ?>

                            <div class="error"><?php echo e($errors->first('email')); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.PHONE'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::text('phone',null,['class'=>'form-control','placeholder'=>trans('admin.PHONE')]); ?>

                            <div class="error"><?php echo e($errors->first('phone')); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.PASSWORD'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::password('password',['class'=>'form-control','placeholder'=>trans('admin.PASSWORD')]); ?>

                            <div class="error"><?php echo e($errors->first('password')); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.CONFIRM_PASSWORD'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::password('confirm_password',['class'=>'form-control','placeholder'=>trans('admin.CONFIRM_PASSWORD')]); ?>

                            <div class="error"><?php echo e($errors->first('confirm_password')); ?></div>
                        </div>
                    </div>
                </div>
                
                      
<!--                       <div class="col-md-6">
                            <div class="form-group">
                                <?php echo Form::label(trans('admin.PROFILE_IMAGE'),null,['class'=>'required_label']); ?>

                                        
                                         <?php echo Form::file('profile_image'); ?>

                                          <div class="error"><?php echo e($errors->first('profile_image')); ?></div>    
                            </div>
                           </div> -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           <?php echo Form::label(trans('admin.STATUS'),null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php $status_list = Config::get('global.status_list'); ?>
                              <?php echo Form::select('status', $status_list, null, ['class' => 'form-control select2 autocomplete']); ?>

                        </div>
                    </div>
                </div>
                
            </div>

            
</div><!-- /.box-body -->


<div class="box-footer">

    <div class="box-footer">
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="pull-right">
                    <?php echo Form::reset(trans('admin.RESET'),['class' => 'btn btn-default ']); ?> 
                    <?php echo Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info ']); ?>

                </div>
            </div>
</div>
<!-- /.box-footer -->

<?php echo Form::close(); ?>


</div><!-- /.box -->


</section><!-- /.content -->
</div>
<style>
.box-body-inner.col-md-6 {
    margin: 0 25%;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>