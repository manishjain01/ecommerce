<?php $__env->startSection('content'); ?>  
<style>
    .dash_user .add_book1 .textarea
    {
        height:80px; !important
    }

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
            <div class="col-md-9 add_book1">
                <h4>Address Book</h4>

                <div>
                    <span class="msg_success">
                        <?php if(Session::has('alert-sucess')): ?>
                        <?php echo Session::get('alert-sucess'); ?>

                        <?php endif; ?>
                    </span>
                    <span class="msg_error">
                        <?php if(Session::has('alert-error')): ?>
                        <?php echo Session::get('alert-error'); ?>

                        <?php endif; ?>
                    </span>
                </div>
                <?php echo Form::model($user,['route'=>['updateAddress',$user->id],'files'=>true,'id' =>'edit_form','style'=>'display:block']); ?>   
                <?php echo csrf_field(); ?>


                <div class="form-group">
                    <?php echo Form::textarea('address_1',null,['class'=>'form-control input-group-lg textarea','placeholder'=>'Address line 1']); ?>

                    <div class="error"><?php echo e(str_replace(' 1', '', $errors->first('address_1'))); ?></div>
                </div>



                <div class="form-group">
                    <?php echo Form::textarea('address_2',null,['class'=>'form-control input-group-lg textarea','placeholder'=>'Address line 2']); ?>

                </div>


                <div class="form-group">
                    <?php echo Form::text('pincode',null,['class'=>'form-control input-group-lg','placeholder'=>'Pincode']); ?>

                    <div class="error"><?php echo e($errors->first('pincode')); ?></div>
                </div>



                <div class="form-group">
                    <?php echo Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']); ?>

                    <div class="error"><?php echo e($errors->first('state')); ?></div>
                </div>



                <div class="form-group">
                    <?php echo Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']); ?>

                    <div class="error"><?php echo e($errors->first('city')); ?></div>
                </div>




                <?php echo Form::submit('Submit',['class' => 'btn btn-default btn-submit']); ?>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</section>


<script>
    $('select[id="state"]').on('change', function () {

        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
        var stateId = $(this).val();


        if (stateId) {
            $.ajax({
                url: '<?php echo SITE_URL; ?>' + '/' + 'state_change/' + stateId,
                type: "POST",
                dataType: "json",
                success: function (data) {


                    $('select[id="city"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="city"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            //$('select[name="city"]').empty();
        }
    });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>