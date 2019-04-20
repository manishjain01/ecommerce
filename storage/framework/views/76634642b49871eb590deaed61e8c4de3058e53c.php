<?php $__env->startSection('content'); ?>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php 
        $admin = adminUser();
        echo trans('admin.HELLO').' '.ucfirst($admin->first_name);
      ?>
    </h1>
  </section>
 <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
             <div class="box-header with-border">
                <h3 class="pull-right">  
                    <?php echo Html::decode(Html::link(route('admin.categories.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])); ?>

                </h3>
            </div>
            <?php echo Form::open(['route'=>'admin.categories.store','files'=>true]); ?>  
            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo Form::label('Category Name',null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::text('cat_name',null,['class'=>'form-control','placeholder'=>'Category Name']); ?>

                            <div class="error"><?php echo e($errors->first('cat_name')); ?></div>
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

    <div class="box-footer">

                <div class="pull-right">
                    <?php echo Form::reset(trans('admin.RESET'),['class' => 'btn btn-default ']); ?> 
                    <?php echo Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info ']); ?>

                </div>
            </div>
</div>
<!-- /.box-footer -->

<?php echo Form::close(); ?>


</div><!-- /.box -->


 </section>
 
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>