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
      <div class="box  box-primary">
         <div class="box-header with-border">
                <h3 class="pull-right">  
                    
                    <?php echo Html::decode(Html::link(route('admin.profile'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn  btn-primary'])); ?>

                </h3>
            </div>
           
      	  <?php echo Form::open(array('method'=>'post','route'=>['admin.UpdateChangePassword'])); ?>

      	 
        <div class="box-body">
<div class='box-body-inner col-md-6'>
          <div class="row">

              <div class="col-md-4">
                        <div class="form-group ">
                             <?php echo Form::label(trans('admin.OLD_PASSWORD'),null, array('class' => 'required_label')); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::password('old_password',['class'=>'form-control','placeholder'=>trans('admin.OLD_PASSWORD')]); ?>

                            <div class="error"><?php echo e($errors->first('old_password')); ?></div>
                        </div>
                    </div>
          </div>
    
    <div class="row">

              <div class="col-md-4">
                        <div class="form-group ">
                             <?php echo Form::label(trans('admin.NEW_PASSWORD'),null,array('class' => 'required_label')); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo Form::password('new_password',['class'=>'form-control','placeholder'=>trans('admin.NEW_PASSWORD')]); ?>

                  <div class="error"><?php echo e($errors->first('new_password')); ?></div>
                        </div>
                    </div>
          </div>
    <div class="row">

              <div class="col-md-4">
                        <div class="form-group ">
                              <?php echo Form::label(trans('admin.CONFIRM_PASSWORD') ,null,array('class' => 'required_label')); ?>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                           <?php echo Form::password('confirm_password',['class'=>'form-control','placeholder'=>trans('admin.CONFIRM_PASSWORD')]); ?>

                 <div class="error"><?php echo e($errors->first('confirm_password')); ?></div>
                        </div>
                    </div>
          </div>
    
          </div><!-- /.row -->
        </div>
        </div><!-- /.box-body -->
          <div class="box-footer">
         
             <div class="pull-right">

                   <?php /*?> {!!  Html::decode(Html::link(route('dashboard'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!} <?php */?>
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