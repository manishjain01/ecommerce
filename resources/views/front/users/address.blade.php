@extends('layouts.home')
@section('content')  
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
                <img src="{{asset('img/banner.png')}}">
             </div>-->
    <div class="container">
        <div class="row">
            @include('includes.frontend.sidebar')
            <div class="col-md-9 add_book1">
                <h4>Address Book</h4>

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
                {!! Form::model($user,['route'=>['updateAddress',$user->id],'files'=>true,'id' =>'edit_form','style'=>'display:block']) !!}   
                {!! csrf_field() !!}

                <div class="form-group">
                    {!! Form::textarea('address_1',null,['class'=>'form-control input-group-lg textarea','placeholder'=>'Address line 1']) !!}
                    <div class="error">{{ str_replace(' 1', '', $errors->first('address_1')) }}</div>
                </div>



                <div class="form-group">
                    {!! Form::textarea('address_2',null,['class'=>'form-control input-group-lg textarea','placeholder'=>'Address line 2']) !!}
                </div>


                <div class="form-group">
                    {!! Form::text('pincode',null,['class'=>'form-control input-group-lg','placeholder'=>'Pincode']) !!}
                    <div class="error">{{ $errors->first('pincode') }}</div>
                </div>



                <div class="form-group">
                    {!! Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']) !!}
                    <div class="error">{{ $errors->first('state') }}</div>
                </div>



                <div class="form-group">
                    {!! Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']) !!}
                    <div class="error">{{ $errors->first('city') }}</div>
                </div>




                {!! Form::submit('Submit',['class' => 'btn btn-default btn-submit'])!!}
                {!! Form::close() !!}
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
                url: '{!! SITE_URL !!}' + '/' + 'state_change/' + stateId,
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

@stop
