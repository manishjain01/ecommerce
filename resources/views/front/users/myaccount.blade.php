@extends('layouts.home')
@section('content')  

 <section class="dash_user">
<!--         <div class="container-fluid">
            <img src="{{asset('img/banner.png')}}">
         </div>-->
         <div class="container">
            <div class="row">
               @include('includes.frontend.sidebar')
               <div class="col-md-9 account_info1 info_displyy">
                  <h4>Dashboard</h4>
                  
					<div class="row">
						<div class="col-md-3 col-xs-3"><p>Name</p></div>
						<div class="col-md-7 col-xs-9"><p>{{$user[0]->first_name}} {{$user[0]->last_name}}</p></div>
						
					    <div class="col-md-2">
							<div class="img_profile_dash">
								<?php //echo $result = substr($user[0]->profile_img, 0, 4);?>
								@if(isset($user[0]->profile_img) &&!empty($user[0]->profile_img))
                                                                    @if(substr($user[0]->profile_img, 0, 4) == 'http')
                                                                        <img alt="" src="{{$user[0]->profile_img}}">
                                                                    @else
                                                                        <img alt="" src="{{USER_IMAGE_URL.$user[0]->profile_img}}">
                                                                    @endif
								@else
								<img alt="" src="{{asset('img/no-image.png')}}">
								@endif
							</div>
						</div>
					    
						<div class="col-md-3 col-xs-3"><p>Email</p></div>
						<div class="col-md-9 col-xs-9"><p>{{$user[0]->email}}</p></div>
						
						<div class="col-md-3 col-xs-3"><p>Mobile</p></div>
						<div class="col-md-9 col-xs-9"><p>{{$user[0]->phone}}</p></div>
						
						<div class="col-md-3 col-xs-3"><p>Address</p></div>
						<div class="col-md-9 col-xs-9"><p>{{$user[0]->address_1.' '.$user[0]->address_2}}, 
                                                        @if(!empty($city->city_name))
                                                        {{$city->city_name}},
                                                        @endif
                                                        @if(!empty($state->state_name))
                                                        {{$state->state_name}},
                                                        @endif
                                                        @if(!empty($user[0]->pincode))
                                                        {{$user[0]->pincode}}
                                                        @endif
                                                    </p></div>
						
					</div>
					
					
               </div>
            </div>
         </div>
      </section>
     

@stop
