    
@extends('layouts.home')

@section('content')  
<style>
.contact_page .contact_fromm .textarea{
	
	height:100px; !important}
	
	.btn_submit{
		display: inline-block;
		background: #333;
		color: #fff;
		border: none;
		letter-spacing: 1px;
		border-radius: 0 !important;
		width: 100%;
		padding: 16px;
		font-size: 18px;
		}
</style>
 <section class="contact_page">
         <div class="container">
            <div class="row headingg">
               <div class="col-md-6">
                  <h2>Please enter a new password</h2>
               </div>
            </div>
            <div class="row address_row contact_fromm">
               <div class="col-md-8">
				   
				   <div>
						<span class="msg_success">
						@if(Session::has('alert-sucess'))
						{!! Session::get('alert-sucess') !!}
						@endif
						</span>
						<span class="msg_error">
						@if(Session::has('alert-error'))
						{!! Session::get('alert-error') !!}
						@endif
						</span>
					</div>
				   
                  {!! Form::open(array('route' => ['front.reset_password',$email_token])) !!}
                     <div class="form-group">
                        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
                        <div class="error">{{ $errors->first('password') }}</div>
                     </div>
                     <div class="form-group">
                        {!! Form::password('confirm_password',['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
                        <div class="error">{{ $errors->first('confirm_password') }}</div>
                        
                     </div>
                     
                    
                     <!--<button type="submit" class="btn btn-default">Submit</button>-->
                     {!! Form::submit('Submit',['class' => 'btn btn-default btn_submit'])!!}
						{!! Form::close() !!}
               </div>
            </div>
         </div>
      </section>


@stop
