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
                    <?php echo Html::decode(Html::link(route('admin.newsletter-subscriber.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])); ?>

                </h3>
            </div>
            <?php echo Form::model($newsletter_subscriber,['method'=>'patch','route'=>['admin.newsletter-subscriber.update',$newsletter_subscriber->id]]); ?>


            <div class="box-body">

                <div class="row">
<div class="col-md-6">

                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.FIRST_NAME'),null,['class'=>'required_label']); ?>

                            <?php echo Form::text('first_name',null,['class'=>'form-control','placeholder'=>trans('admin.FIRST_NAME')]); ?>

                            <div class="error"><?php echo e($errors->first('first_name')); ?></div>
                        </div><!-- /.form-group -->              
                        <div class=" form-group ">
                            <?php echo Form::label(trans('admin.LAST_NAME'),null,['class'=>'required_label']); ?>

                            <?php echo Form::text('last_name',null,['class'=>'form-control','placeholder'=>trans('admin.LAST_NAME')]); ?>

                            <div class="error"><?php echo e($errors->first('last_name')); ?></div>
                        </div><!-- /.form-group -->
                         <div class=" form-group ">
                            <?php echo Form::label(trans('admin.EMAIL'),null,['class'=>'required_label']); ?>

                            <?php echo Form::text('email',null,['class'=>'form-control','placeholder'=>trans('admin.EMAIL')]); ?>

                            <div class="error"><?php echo e($errors->first('email')); ?></div>
                        </div><!-- /.form-group -->

                        
                        
                        <div class="form-group ">
                            <?php echo Form::label(trans('admin.STATUS'),null,['class'=>'required_label']); ?>

                            <?php $status_list = Config::get('global.status_list'); ?>
                            <?php echo Form::select('status', $status_list, null, ['class' => 'form-control']); ?>

                        </div><!-- /.form-group -->


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">

                    <?php echo Html::decode(Html::link(route('admin.newsletter-subscriber.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])); ?>

                    <?php echo Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info ']); ?>

                </div>
            </div>
            <!-- /.box-footer -->
            <?php echo Form::close(); ?>

        </div><!-- /.box -->
    </section><!-- /.content -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>