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
                        <div class="pull-right">
                       
                
                            <?php echo Html::decode(Html::link(route('admin.adminmenus.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])); ?> 

                            

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('name', trans('admin.ICON')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('name', trans('admin.NAME')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('menu_order', trans('admin.ORDER')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('menu_order', trans('admin.SHOW_ON_DESHBOARD')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at', trans('admin.CREATED_AT')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('updated_at', trans('admin.UPDATED_AT')));?></th>
                                    <th  width="15%" align="center"><?php echo e(trans('admin.ACTION')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$admin_menu_list->isEmpty()): ?>
                                <?php foreach($admin_menu_list as $admin_menu): ?>
                                <tr>
                                    <td><i class="fa  <?php echo e($admin_menu->icon); ?>"> </i></td>
                                    <td><?php echo e(ucfirst($admin_menu->name)); ?></td>
                                    <td><?php echo e(ucfirst($admin_menu->menu_order)); ?></td>
                                      <td> <?php if($admin_menu->is_deshboard): ?>

                                                  <?php echo e(trans('admin.YES')); ?>

                                           <?php else: ?>
                                            <?php echo e(trans('admin.No')); ?>

                                    <?php endif; ?>
                                    </td>
                                    <td><?php echo e(date_val($admin_menu->created_at,DATE_FORMATE )); ?></td>
                                    <td><?php echo e(date_val($admin_menu->updated_at,DATE_FORMATE )); ?></td>
                                    <td align="center">
                                        <?php if($admin_menu->status == 1): ?>
                                        <?php echo Html::decode(Html::link(route('admin.adminmenus.status_change',['id' => $admin_menu->id,'status'=>$admin_menu->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])); ?>

                                        <?php else: ?>
                                        <?php echo Html::decode(Html::link(route('admin.adminmenus.status_change',['id' => $admin_menu->id,'status'=>$admin_menu->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])); ?>

                                        <?php endif; ?>
                                        <?php echo Html::decode(Html::link(route('admin.adminmenus.edit',['id'=>$admin_menu->id]),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>

                                        <?php echo Html::decode(Html::link(route('admin.adminmenus.child_menu',['id'=>$admin_menu->id]),"<i class='fa   fa-code-fork'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.CHILD_MENU')])); ?>


                                    </td>
                                    <?php endforeach; ?>
                                    <?php else: ?>

                                <tr><td colspan="7"><div class="data_not_found"> Data Not Found </div></td></tr>


                                <?php endif; ?>

                            </tbody>
                        </table>
                        <?php echo $admin_menu_list->appends(Input::all('page'))->render(); ?>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>