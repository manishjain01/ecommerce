  <!-- Content Wrapper. Contains page content -->
  @extends('layouts.default')

  @section('content')  

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
                        <div class="pull-right">
                           {!!  Html::decode(Html::link(route('admin.emailtemplates.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}

                        </div>
                    </div><!-- /.box-header -->
      	  {!! Form::model($emailtemplates,['method'=>'patch','route'=>['admin.emailtemplates.update',$emailtemplates->id]]) !!}
      	 
        <div class="box-body">

          <div class="row">

            <div class="col-md-12">

              <div class="form-group col-md-6">
              	 {!! Form::label(trans('admin.NAME'),null,array('class' => 'required_label')) !!}
              	 {!! Form::text('name',$emailtemplates->name,['class'=>'form-control','placeholder'=>'Name']) !!}
                 <div class="error">{{ $errors->first('title') }}</div>
             
              </div><!-- /.form-group -->

              <div class="form-group col-md-6">
                 {!! Form::label(trans('admin.SUBJECT'),null,array('class' => 'required_label')) !!}
                 {!! Form::text('subject',$emailtemplates->subject,['class'=>'form-control','placeholder'=>'Subject']) !!}
              </div><!-- /.form-group -->

              <div class="form-group col-md-4">
                 {!! Form::label(trans('admin.INSERT_CONSTRAINTS'),null,array('class' => '')) !!}
                <?php $constraints = explode(',',$emailtemplates->template_constants);
                  $constraints_array  = array();
                  $constraints_array['']  = '--';
                  foreach ($constraints as $key => $value) {
                    $constraints_array[$value]  = $value;
                  }
                 ?>
                 {!! Form::select('template_constants', $constraints_array,null,['class'=>' autocomplete select2 form-control','id'=>'list_constant']) !!}


              </div><!-- /.form-group -->
              <div class="col-md-2"></br>{!! Form::button('Insert',['class' => 'btn btn-info','id'=>'insert_constatnt'])!!}</div>
               <div class="form-group col-md-12">
                 {!! Form::label('Body',null,array('class' => 'required_label')) !!}
              	 {!! Form::textarea('body',$emailtemplates->body,['class'=>'form-control ckeditor','placeholder'=>'Body', 'id'=>'ck_editor']) !!}
               </div><!-- /.form-group -->
             
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.box-body -->
          <div class="box-footer">
          <?php  //echo $this->Form->button('Register', ['name' => 'Register', 'value' => 'Register', 'class' => 'btn btn-info pull-right']); ?>
          {!! Form::submit('Update',['class' => 'btn btn-info pull-right'])!!}
          </div>
          <!-- /.box-footer -->
         {!! Form::close() !!}
      </div><!-- /.box -->
    </section><!-- /.content -->
    </div>

    <script type="text/javascript">
      $(document).ready(function(){ 
          $('#insert_constatnt').click(function()
  {
  
    var current_template_instance = "ck_editor";
    var current_text        = $("#list_constant").val();
    var oEditor           =   CKEDITOR.instances[current_template_instance] ;
    oEditor.insertHtml(current_text) ;
    
  });

      });

    </script>
  @stop
