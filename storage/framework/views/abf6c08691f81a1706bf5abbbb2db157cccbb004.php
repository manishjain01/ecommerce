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
        <div class="box-header with-border">
            <h3 class="pull-right">  
                <?php echo Html::decode(Html::link(route('admin.pincode.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])); ?>

            </h3>
        </div>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
			
			
			<?php if(Session::has('alert-sucess')): ?>
                <div class="alert alert-info alert-dismissible" role="alert" id="message">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo Session::get('alert-sucess'); ?>

                </div>
            <?php endif; ?>
            <?php if(Session::has('alert-error')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert" id="message">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo Session::get('alert-error'); ?>

                </div>
            <?php endif; ?>
			

            <?php echo Form::model($plan,['method'=>'patch','route'=>['admin.pincode.update',$plan->id],'files'=>true]); ?>


            <div class="box-body">
                <div class='box-body-inner col-md-6'>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <?php echo Form::label('Pincode',null,['class'=>'required_label']); ?>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <?php echo Form::text('pincode',null,['class'=>'form-control','placeholder'=>'Pincode']); ?>

                                <div class="error"><?php echo e($errors->first('pincode')); ?></div>
                            </div>
                        </div>
                    </div>
                   

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
                <div class="pull-right">

                    <?php echo Html::decode(Html::link(route('admin.pincode.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])); ?>

                    <?php echo Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info ']); ?>

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