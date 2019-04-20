<!-- Content Wrapper. Contains page content -->


<?php $__env->startSection('content'); ?>  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header with-border">
        <h1>
            <?php echo e($pageTitle); ?>

        </h1>
        <?php echo $__env->make('includes.admin.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                      
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('title', 'Email'));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at', trans('admin.CREATED_AT')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('updated_at', trans('admin.UPDATED_AT')));?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$newsletterlist->isEmpty()): ?>
                                <?php foreach($newsletterlist as $newsletter): ?>
                                <tr>
                                    
                                    <td><?php echo e($newsletter->email); ?></td>
                                    <td><?php echo e(date_val($newsletter->created_at,DATE_FORMATE )); ?></td>
                                    <td><?php echo e(date_val($newsletter->updated_at,DATE_FORMATE )); ?></td>
                                  
                                    <?php endforeach; ?>
                                    <?php else: ?>

                                <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                                <?php endif; ?>

                            </tbody>
                        </table>
                        <?php echo $newsletterlist->appends(Input::all('page'))->render(); ?>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>