
<style type="text/css">
    .navbar1 a {
        float: left;
        font-size: 16px;
        color: white;
        text-align: center;
        padding: 6px 16px;
        letter-spacing: 1px;
        text-decoration: none;
    }

    .subnav1 {
        float: left;
        overflow: hidden;
    }

    .subnav1 .subnavbtn1 {
        font-size: 20px;  
        border: none;
        outline: none;
        color: #343434;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        padding-bottom: 30px;
        margin: 0;
        letter-spacing: 1px;
        position: relative;
    }
    .subnav1 .fa{
        position: absolute;
        color: #38b861;
        /* bottom: 71px; */
        right: 30px;
        font-size: 27px;
        padding: 15px;
        display: none;
    }
    .navbar1 a:hover, .subnav1:hover .subnavbtn1 {
        color: #38b861;

    }

    .subnav-content1 {
        //display: none;
        position: absolute;
        left: 0;
        background-color: #fff;
        width: 70%;
        z-index: 1;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        top:119px;

        padding: 30px 0px;
        box-shadow: 0px 0px 6px 0px #c4c0c0;
    }
    .subnav-content1 h4{

        border-bottom: 1px solid #38b861;
        padding-bottom: 10px;
        margin-bottom: 10px;
        letter-spacing: 1px;
        font-size: 19px;
    }

    .subnav-content1 a {

        color: #343434;
        text-decoration: none;
    }
    .subnav-content1 ul{
        display: grid;
    }

    .subnav-content1 a:hover {
        color: #38b861;

    }

    .subnav1:hover .subnav-content1 {
        display: block;
        margin-left:auto;
        margin-right:auto;

    }
    .navbar-collapse{
        padding-left: 42%;
    }

    @media screen and (max-width: 767px) {
        .subnav-content1{
            width: 100%;
            max-height: 350px;
            overflow-x: scroll;
            top:160px;
        }
        .women_cat_content{
            top:214px;
        }
        .subnav1 .subnavbtn1 {
            font-size: 20px;
        }
        .navbar-header{
            width: 100%;
        }
        .subnav1{
            float: inherit;
        }
        .subnav1 .subnavbtn1{
            padding-bottom: 15px;
            width: 100%;
            text-align:left;
        }
        .subnav1 .subnavbtn1:hover{
            color: #38b861;
        }
        .navbar-collapse{
            padding: 0px;
            padding-top: 0px !important;
            padding-bottom: 15px;
            border-bottom: 1px solid gray;


        }
        .subnav1 .active{
            background: #1c1c1c;
            color: #fff;

        }
        .navbar-nav{
            margin: 0% !important;
        }

        .subnav1 .fa{
            display: block;
        }
        .navbar-nav{
            padding-bottom:0px;
            background:none;
        }
        #demo_2 input[type=search]:focus{
            width:75%;
        }	
        
        .subnav1:hover .subnav-content1 {
			display:none;
			}  
    
    }
    @media screen and (max-width: 1300px) and (min-width: 1000px) {
        .subnav-content1{
            width: 90%;
        }
    }
</style>

<div class="preloader-area-wrap">
    <div class="spinner d-flex justify-content-center align-items-center h-100">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<nav class="navbar navbar-inverse sticky">
    <div class="container-fluid top_row">  
        <div class="row">
            <div class="col-md-6"> 

            </div>
            <div class="col-md-6 social_card">
                <ul>
                    <li class="dropdown_wish_new">

                        <div class="dropbtn_wish_new"><a href="javascript:void(0)"><i class="fa fa-heart-o" aria-hidden="true"></i>
                                @if(Auth::check())
                                <?php $auth = LoginUser();
                                     $count = CommonHelpers::count_wishlist($auth->id);
                                    ?>
                                <sup class="count_wish" <?php if(empty($count) && $count == 0){?> style="display:none;" <?php }?>>
                                   {{$count}} 
                                </sup>
                                @endif 

                            </a>
                        </div> 
                        <div class="dropdown-content_wish_new">
                            
                            @if(Auth::check())

                            <h3>YOUR WISHLIST 

                                <?php /*?><sup class="count_wish">
                                    <?php $auth = LoginUser();
                                    echo $count = CommonHelpers::count_wishlist($auth->id);
                                    ?>
                                </sup><?php */?>
                            </h3>


							<?php $wishlistProducts = CommonHelpers::allWishlistProducts($auth->id); ?>
                            <ul id="wishlist_dropdown">
                                @foreach($wishlistProducts as $key=>$value) 
                                <?php 
                                $images = CommonHelpers::getProductImage($value->product_id, $value->color_id);
                                $colorLists = CommonHelpers::getProductColor($value->color_id); ?>
                                <li>
                                    <a href="{{URL::to('productDetail/'.$value->slug.'/'.$colorLists->slug)}}">
                                        <img src="{{PRODUCT_IMAGE_URL.$images['0']['image_name']}}">
                                        <h4>{{$value->product_title}}</h4> 
                                        <span>
                                            {!! CURRENCY !!}&nbsp;<b>  
                                                <?php $discounts = "";
                                                if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                                                $discounts = ($value->discount/100)*$value->price_usd;
                                                echo $value->price_usd-$discounts;
                                                }else{
                                                $discounts = ($value->discount/100)*$value->price;
                                                echo $value->price-$discounts;
                                                }?>
                                            </b></span>
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                            <a href="{{URL::to('user_wishlist')}}" class="wish_listst">GO TO WISHLIST</a>
                            @endif
                        </div>
                    </li>
                    <?php
                    if(Auth::check()){
                    $auth = LoginUser();
                    $userId = $auth->id;
                    }else{
                      $userId = 0;  
                    }
                    $session_id = session()->getId();
                    //echo $session_id;exit;
                    $countCart = CommonHelpers::count_cartlist($session_id, $userId);
                    ?>
                    <li>
			<a href="{{URL::to('cartDetail/')}}" ><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            
                            <sup class="shopping-cart" <?php if(empty($countCart) && $countCart == 0){?> style="display:none;" <?php }?>>
                                
                                {{ $countCart}}
                                
                            </sup>
                            
                        </a>
                    </li>
                    @if(Auth::check())
                    @if($auth)
                    <li>
                        {!! HTML::link(route('myaccount'), ucfirst($auth->first_name), array('class' => '')) !!} |
                        {!! HTML::link(route('web.logout'), 'Logout', array('class' => '')) !!}        
                    </li>
                    @endif
                    @else
                    <li>
                        <a href="javascript:void(0)" id="myBtn_login1">Login</a> | 
                        <a href="javascript:void(0)"  id="myBtn_sign1">Sign Up</a>
                    </li>
                    <li class="search-media-icon">
                        
                        {!! Form::open(array('route' => 'product_search', 'novalidate' => 'novalidate', 'id' => 'demo_2')) !!}
                        
                            <i class="fa fa-search" aria-hidden="true" id="searchBox"></i>
                            <div id="dropsearchBox" class="search-media-textbox">
                            <input type="search" placeholder="Search by product name" name="search" />
                            </div>
                        {!! Form::close() !!}
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
    <!--<div class="container-fluid">
      <div class="navbar-header col-md-4">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="{{URL::to('/')}}"><img src="{{asset('img/logo.png')}}"></a>
      </div>
      <div class="collapse navbar-collapse col-md-8" id="myNavbar">
        <ul class="nav navbar-nav">
    <?php $catLists = CommonHelpers::getcatlist();
    ?>
         @foreach($catLists as $key=> $catList)
<?php $catSubLists = CommonHelpers::getsubCatlist($catList->id);
?>
          <li class="<?if($key == 0 ){?>active<? } ?> dropdown_nav"><a href="{{URL::to('productCat/'.$catList->slug)}}" id="flip_drp{{$key}}" class="dropbtn_nav">{{ strtoupper($catList->cat_name) }}</a>
                          
                          @if(!$catSubLists->isEmpty())
                          
                    <div class="dropdown-content_nav" id="panel_drp{{$key}}">
                            @foreach($catSubLists as $catSubList)
                            <a href="{{URL::to('productCat/'.$catList->slug.'/'.$catSubList->slug)}}">{{ ucfirst($catSubList->cat_name) }}</a>
                            @endforeach
                            
                    </div>
                   @endif
                  <script> 
                  $(document).ready(function(){
                          $("#flip_drp{{$key}}").click(function(){
                                  $("#panel_drp{{$key}}").slideToggle("slow");
                          });
                  });
                  </script>
          </li>
          @endforeach
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li> 
                          <form id="demo_2">
                          <input type="search" placeholder="Search" >
                          </form>
                  </li>
        </ul>
      </div>
    </div>-->

    <div class="container-fluid ">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="{{URL::to('/')}}"><img src="{{asset('img/logo.png')}}"></a>
        </div>
        <div class="collapse navbar-collapse navbar1" id="myNavbar">

            <?php $catLists = CommonHelpers::getcatlist(); ?>	
            @foreach($catLists as $key=> $catList)
<?php $catSubLists = CommonHelpers::getsubCatlist($catList->id);
?>
            <div class="subnav1">
                <a href="{{URL::to('productCat/'.$catList->slug)}}" class="subnavbtn1">{{ strtoupper($catList->cat_name) }}</a><i class="fa fa-caret-down flip_drp{{$key}}" onclick="flip_drp({{$key}})" aria-hidden="true" id="flip_drp{{$key}}"></i>

                @if($catList->slug=='women')
                <div class="subnav-content1 women_cat_content panel_men{{$key}}" id="panel_men{{$key}}">
                    @else
                    <div class="subnav-content1 panel_men{{$key}}" id="panel_men{{$key}}">
                        @endif  

                        <div class="col-md-12">
						@if(!$catSubLists->isEmpty()) 
						@foreach($catSubLists as $catSubList)
						<?php $catSubSubLists = CommonHelpers::getsubsubCatlist($catSubList->id);
						?>

                            <div class="<?if($catList->slug=='men'){?> col-md-3 <?} else {?>col-md-4<? } ?>">
                                <ul>
                                    <a href="{{URL::to('productCat/'.$catList->slug.'/'.$catSubList->slug)}}"><h4>{{ ucfirst($catSubList->cat_name) }}</h4></a>
                                    @foreach($catSubSubLists as $catSubSubList)
                                    <li> <a href="{{URL::to('productCat/'.$catList->slug.'/'.$catSubList->slug.'/'.$catSubSubList->slug)}}">{{ ucfirst($catSubSubList->cat_name) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

               
                @endforeach

                <ul class="nav navbar-nav navbar-right">
                    <li> 
                        {!! Form::open(array('route' => 'product_search', 'novalidate' => 'novalidate', 'id' => 'demo_2')) !!}
                        
                        <input type="search" placeholder="Search by product name" name="search" />
                        <?php /*?>{!! Form::button('<i class="glyphicon glyphicon-search"></i>', array('type' => 'submit', 'class' => 'btn btn-success')) !!}<?php */?>
                        {!! Form::close() !!}
                    </li>
                </ul>
            </div>
        </div>
</nav>
	<script>
		
		function flip_drp(key) {
			  $(".panel_men"+key).toggle();
			}
		/*
		$(document).ready(function () {
			$(".flip_drp{{$key}}").click(function () {
				$(".panel_men{{$key}}").toggle();
			});
		});*/
        $(document).ready(function(){
          $('#searchBox').click(function(){
            $('#dropsearchBox').slideToggle(200);
          });
        });
	</script>
