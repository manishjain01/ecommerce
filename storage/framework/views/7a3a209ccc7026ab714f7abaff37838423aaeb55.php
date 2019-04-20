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
                           

                            

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%"><?php echo e(trans('admin.NEWSLETTER')); ?></th>
                                    <th width="30%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('email', trans('admin.EMAIL')));?></th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at', trans('admin.CREATED_AT')));?></th>
                                    <th  width="30%" align="center"><?php echo e(trans('admin.ACTION')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$newsletter_campaign->isEmpty()): ?>
                                <?php foreach($newsletter_campaign as $campaign): ?>
                                <tr>
                                    <td><?php echo e(ucfirst($campaign->newsletterName->title)); ?></td>
                                    <td><?php echo e($campaign->email); ?></td>
                                    
                                    <td><?php echo e(date_val($campaign->updated_at,DATE_FORMATE )); ?></td>
                                    <td align="center">
                                                     <?php if($campaign->mail_send == 0): ?>

                                        <?php if($campaign->status == 1): ?>
                                        <?php echo Html::decode(Html::link(route('admin.newsletter-campaign.status_change',['id' => $campaign->id,'status'=>$campaign->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])); ?>

                                        <?php else: ?>
                                        <?php echo Html::decode(Html::link(route('admin.newsletter-campaign.status_change',['id' => $campaign->id,'status'=>$campaign->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])); ?>


                                        <?php endif; ?>
                                        <?php echo Html::decode(Html::link(route('admin.newsletter-campaign.delete', $campaign->id),"<i class='fa  fa-trash'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.DELETE'), "data-alert"=>trans('admin.DELETE_ALERT')])); ?>

                                        <?php echo Html::decode(Html::link(route('admin.newsletter-campaign.send_mail', $campaign->id),"<i class='fa  fa-send'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.SEND_MANUALLY')])); ?>


                                    <?php else: ?>

                                         <?php echo Html::decode(Html::link('#javascript:void;',"<i class='fa  fa-calendar-plus-o'></i>",['class'=>'btn btn-info','data-toggle'=>'tooltip','title'=>trans('admin.EXECUTED')])); ?>





                                       <?php endif; ?> 
                              
                                        
                                     
                                       

                                    </td>
                                    <?php endforeach; ?>
                                    <?php else: ?>

                                <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                                <?php endif; ?>

                            </tbody>
                        </table>
                        <?php echo $newsletter_campaign->appends(Input::all('page'))->render(); ?>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>