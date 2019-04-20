<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')

@section('content')  

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        @include('includes.admin.breadcrumb')
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="pull-right">  
                    {!!  Html::decode(Html::link(route('admin.cms.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                </h3>
            </div>
            {!! Form::open(['route'=>'admin.cms.store']) !!}  
            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.TITLE'),null,['class'=>'required_label']) !!}
                            {!! Form::text('title',null,['class'=>'form-control','placeholder'=>trans('admin.TITLE')]) !!}
                            <div class="error">{{ $errors->first('title') }}</div>
                        </div><!-- /.form-group -->

                        <div class="form-group col-md-12 ">
                            {!! Form::label(trans('admin.DESCRIPTION'),null,['class'=>'required_label    ']) !!}
                            {!! Form::textarea('description',null,['class'=>'form-control ckeditor','placeholder'=>trans('admin.DESCRIPTION')]) !!}
                            <div class="error">{{ $errors->first('description') }}</div>
                        </div><!-- /.form-group -->

                        <div class="form-group col-md-6 ">
                            {!! Form::label(trans('admin.META_KEYWORDS'),null,['class'=>'required_label    ']) !!}
                            {!! Form::textarea('meta_keywords',null,['class'=>'form-control ','placeholder'=>trans('admin.META_KEYWORDS')]) !!}
                            <div class="error">{{ $errors->first('meta_keywords') }}</div>
                        </div><!-- /.form-group -->  
                        <div class="form-group col-md-6 ">
                            {!! Form::label(trans('admin.META_DESCRIPTION'),null,['class'=>'required_label']) !!}
                            {!! Form::textarea('meta_description',null,['class'=>'form-control ','placeholder'=>trans('admin.META_DESCRIPTION')]) !!}
                            <div class="error">{{ $errors->first('meta_description') }}</div>
                        </div><!-- /.form-group -->
                        <div class="form-group col-md-6 ">
                            {!! Form::label(trans('admin.META_TITLE'),null,['class'=>'required_label']) !!}
                            {!! Form::text('meta_title',null,['class'=>'form-control ','placeholder'=>trans('admin.META_TITLE')]) !!}
                            <div class="error">{{ $errors->first('meta_title') }}</div>
                        </div><!-- /.form-group --> 
                        <div class="form-group col-md-6">
                            {!! Form::label(trans('admin.STATUS'),null,['class'=>'required_label']) !!}
                            <?php $status_list = Config::get('global.status_list'); ?>
                            {!! Form::select('status', $status_list, null, ['class' => 'form-control']) !!}
                        </div><!-- /.form-group -->


                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.box-body -->


            <div class="box-footer">

                <div class="pull-right">
                    {!! Form::reset(trans('admin.RESET'),['class' => 'btn btn-default '])!!} 
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
            <!-- /.box-footer -->

            {!! Form::close() !!}

        </div><!-- /.box -->


    </section><!-- /.content -->
</div>

@stop

