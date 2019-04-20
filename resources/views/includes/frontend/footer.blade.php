<style>
    .wishlist-btn-color{
        color: red !important;
    }
    .reset{
        margin-top:20px;
    }
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<footer id="footer-area">
    <div class="footer-widget-area pt-40 pb-28">
        <div class="container">
            <div class="footer-widget-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-widget-item-wrap">
                            <h3 class="widget-title">Company</h3>
                            <div class="widget-body">
                                <ul class="footer-list">
                                    <?php $cmslist = CommonHelpers::getcmslist(); //pr($cmslist);   ?>
                                    @foreach($cmslist as $list)
                                    <li><a href="{{URL::to('page/'.$list['slug'])}}" >{{ $list['title']}}</a></li>
                                    @endforeach 
                                    <li><a href="{{URL::to('contact')}}">Contact Us</a></li> 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-widget-item-wrap add_p">
                            <h3 class="widget-title">Contact Us</h3>
                            <p></p>
                            <div class="widget-body">
                                <ul class="footer-list">
                                    <li><a href="javascript:void(0);"><i class="fa fa-map-marker" aria-hidden="true"></i> {!! Configure('CONFIG_POSTAL_ADDRESS') !!}</a></li>
                                    <li><a href="javascript:void(0);"><i class="fa fa-phone" aria-hidden="true"></i> {{Configure('CONFIG_PHONE')}}</a></li> 
                                    <li><a href="javascript:void(0);"><i class="fa fa-envelope" aria-hidden="true"></i> {{Configure('CONFIG_FROMEMAIL')}}</a></li> 
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="footer-widget-item-wrap scl_ftr">
                            <h3 class="widget-title">Connect With Us</h3>
                            <div class="widget-body">
                                <ul class="footer-list">
                                    <li><a href="{{Configure('CONFIG_FACEBOOK')}}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="{{Configure('CONFIG_LINKEDIN')}}" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="{{Configure('CONFIG_THUMBLR')}}" target="_blank"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>
                                    <li><a href="{{Configure('CONFIG_PINTEREST')}}" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li><a href="{{Configure('CONFIG_TWITTER')}}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="{{Configure('CONFIG_GPLUS')}}" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    <li><a href="{{Configure('CONFIG_IMGUR')}}" target="_blank"><i class="fa fa-picture-o" aria-hidden="true"></i></a></li>
                                </ul>
                                <p>100% Secure Payment</p>
                                <img src="{{asset('img/pay.png')}}">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="footer-bottom-wrapper">

        <div class="container">

            <div class="row">
                <div class="col-md-3">
                    <img src="{{asset('img/logo-footer.png')}}">
                </div>

                <div class="col-md-4">
                   
                </div>

                <div class="col-md-5">   
                    <span style="color: #38b861;
    font-size: 18px;">Subscribe For Newsletter</span>
                    {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'newsletter_form')) !!}
                    <input type="text" name="news_email" id="news_email" placeholder="Enter Your Email.">
                    <button id="subscribe">Subscribe</button>
                    {!! Form::close() !!}
<p class="success-msg3 login-error" style="color:#fff;"></p>
                </div>
                
            </div>
        </div>
    </div>
    <div class="container-fluid footer_btm_last">  </div>  
</footer>

<div class="modalSearchBox" id="search-box-popup">
    <div class="modaloverlay"></div>
    <div class="search-box-wrapper">
        <p>Start typing and press Enter to search</p>
        <div class="search-box-form">

            <form action="#" method="POST" class="search-form-area">
                <input type="search"  name="search" id="search" placeholder="Search entire store" />
                <button type="submit" class="btn-search"><i class="dl-icon-search10"></i></button>
            </form>
        </div>
    </div>
</div>
<div class="mfp-hide modal-minicart" id="miniCart-popup">

    <div class="minicart-content-wrap">
        <h2>Shopping Cart</h2>
        <div class="minicart-product-list">
            <div class="single-product-item d-flex">
                <figure class="product-thumb">
                    <a href="single-product.html"><img src="{{asset('img/products/prod-1-1.jpg')}}" alt="Product"></a>
                </figure>

                <div class="product-details">
                    <h2 class="product-title"><a href="single-product.html">Stripe textured dress</a></h2>
                    <div class="prod-cal d-flex align-items-center">
                        <span class="quantity">1</span>
                        <span class="multiplication">&#215;</span>
                        <span class="price">$99.99</span>
                    </div>
                </div>

                <a href="#" class="remove-icon">&#215;</a>

            </div>
            <div class="single-product-item d-flex">
                <figure class="product-thumb">
                    <a href="single-product.html"><img src="{{asset('img/products/prod-2-1.jpg')}}" alt="Product"></a>
                </figure>
                <a href="#" class="remove-icon">&#215;</a>
            </div>

            <div class="single-product-item d-flex">
                <figure class="product-thumb">
                    <a href="single-product.html"><img src="{{asset('img/products/prod-3-1.jpg')}}" alt="Product"></a>
                </figure>
                <a href="#" class="remove-icon">&#215;</a>
            </div>

            <div class="single-product-item d-flex">
                <figure class="product-thumb">
                    <a href="single-product.html"><img src="{{asset('img/products/prod-4-1.jpg')}}" alt="Product"></a>
                </figure>
                <a href="#" class="remove-icon">&#215;</a>
            </div>
        </div>

        <div class="minicart-calculation-wrap d-flex justify-content-between align-items-center">
            <span class="cal-title">Subtotal:</span>
            <span class="cal-amount">£119.97</span>
        </div>

        <div class="minicart-btn-group mt-38">
            <a href="cart.html" class="btn btn-black ">View Cart</a>
            <a href="checkout.html" class="btn btn-black mt-10">checkout</a>
        </div>
    </div>
</div>

<div class="modal" id="quickViewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="dl-icon-close"></i></span>
            </button>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-5 col-md-6">
                        <div class="single-product-thumb-wrap p-0 pb-sm-30 pb-md-30">
                            <div class="quciview-product-thumb-carousel">
                                <figure class="product-thumb-item">
                                    <img src="{{asset('img/products/prod-1-1.jpg')}}" alt="Single Product"/>
                                </figure>

                                <figure class="product-thumb-item">
                                    <img src="{{asset('img/products/prod-1-2.jpg')}}" alt="Single Product"/>
                                </figure>

                                <figure class="product-thumb-item">
                                    <img src="{{asset('img/products/prod-2-1.jpg')}}" alt="Single Product"/>
                                </figure>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 m-auto">
                        <div class="single-product-content-wrapper">
                            <div class="single-product-details">
                                <h2 class="product-name">Open-knit sweater</h2>
                                <div class="prices-stock-status d-flex align-items-center justify-content-between">

                                    <div class="prices-group">
                                        <del class="old-price">$50.00</del>
                                        <span class="price">$40.00</span>
                                    </div>
                                    <span class="stock-status"><i class="dl-icon-check-circle1"></i> In  Stock</span>
                                </div>



                                <p class="product-desc">Ut enim added minim veniam, quis nostrud exercitation ullamco ommodo
                                    consequat. Duis aute irure dolor in reprehenderit dolore eu fugiat nulla pariatur. Excepteur
                                    sint occaecat cupidatat non proident. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab dolorem eum labore minima possimus quaerat quod recusandae repellat sequiut.</p>
                                <div class="quantity-btn-group d-flex">
                                    <div class="pro-qty">
                                        <input type="text" id="quantity" value="1"/>
                                    </div>

                                    <div class="list-btn-group">
                                        <a href="cart.html" class="btn btn-black">Add to Cart</a>
                                        <a href="wishlist.html" data-toggle="tooltip" data-placement="top" title="Add to wishlist"><i class="dl-icon-heart2"></i></a>
                                        <a href="compare.html" data-toggle="tooltip" data-placement="top" title="Add to Compare"><i class="dl-icon-compare2"></i></a>

                                    </div>
                                </div>
                                <div class="find-store-delivery">
                                    <a href="#"><i class="fa fa-map-marker"></i> Find store near you</a>
                                    <a href="#"><i class="fa fa-exchange"></i> Delivery and return</a>
                                </div>
                            </div>
                            <div class="single-product-footer mt-20 pt-20">
                                <div class="prod-footer-right">
                                    <dl class="social-share">

                                        <dt>Share with</dt>
                                        <dd><a href="{{Configure('CONFIG_FACEBOOK')}}"><i class="fa fa-facebook"></i></a></dd>
                                        <dd><a href="{{Configure('CONFIG_TWITTER')}}"><i class="fa fa-twitter"></i></a></dd>
                                        <dd><a href="{{Configure('CONFIG_PINTEREST')}}"><i class="fa fa-pinterest-p"></i></a></dd>
                                        <dd><a href="{{Configure('CONFIG_GPLUS')}}"><i class="fa fa-google-plus"></i></a></dd>

                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- The Modal -->
<div id="myModal_login1" class="modal_login1">
    <!-- Modal content -->
    <div class="modal-content_login1 aaaa">
        <span class="close_login1">&times;</span>
        <p class="success-msg1 login-error" style="color:green;"></p>
        <h2>Login</h2>
        {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'login_form')) !!}
        <input type="hidden" name="_Token" value="{{ csrf_token() }}">
        <div class="user-input-wrp"><br/>
            {!! Form::email('email',null,['class'=>'inputText', 'id'=>'email','required' => '']) !!}
            <span class="floating-label">Your email address</span>
        </div>
        <div class="user-input-wrp pas"><br/>
            {!! Form::password('password',['class'=>'inputText', 'id'=>'password','required' => '']) !!}
            <span class="floating-label">Your password</span>
        </div>
        <br>
        <div class="passwrd" id="passwrd">
            <a href="javascript:void(0);">Forgot Password</a>
        </div>
        <button id="login" class="cs">Continue</button>
        <div class="saperator-line text-center">
            <p>OR</p>
        </div>
        <div class="text-center">
        @if(CURRENCY == '<i class="fa fa-inr" aria-hidden="true"></i>')
        <a href="{{ route('facebook.login') }}" class="btn btn-facebook text-center"><i class="fa fa-facebook"></i> Facebook</a>
        <a href="{{ route('instagram.login') }}" class="btn btn-instagram"><i class="fa fa-instagram"></i> Instagram</a>
        @endif
        </div>
        {!! Form::close() !!}
    </div>


    <div class="modal-content_login1 forgot_password" style="display:none;">
        <span class="close_login2">&times;</span>
        <p class="success-msg login-error" style="color:green;"></p>
        <h2>Forgot Password</h2>
        {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'forgot_password')) !!}
        <input type="hidden" name="_Token" id="forgot_token" value="{{ csrf_token() }}">
        <div class="user-input-wrp"><br/>
            {!! Form::email('username',null,['class'=>'inputText', 'id'=>'username','placeholder'=>'Your email address','required' => '']) !!}
<!--            <span class="floating-label">Your email address</span>-->
        </div>
        <div class="passwrd" id="login_form1">
            <a href="javascript:void(0);">Login</a>
        </div>
        {!! Form::button('Email Reset Link',['class'=>'cs reset', 'id'=>'forgot_id'])!!}  
        {!! Form::close() !!}
    </div>



</div>

<script>
	$('.login_wishlist').click(function(){
		$('#myModal_login1').show();
	});
	
	
$("#passwrd").click(function () {
    $('.forgot_password').show();
    $('.aaaa').hide();
    $('.success-msg').text('');
});
$("#login_form1").click(function () {
    $('.aaaa').show();
    $('.forgot_password').hide();
    $('.success-msg').text('');
});
</script>



<script>
	$( document ).ready(function() {
	
// Get the modal
    var modal_login1 = document.getElementById('myModal_login1');

// Get the button that opens the modal
    var btn_login1 = document.getElementById("myBtn_login1");

// Get the <span> element that closes the modal
    var span_login1 = document.getElementsByClassName("close_login1")[0];
    var span_login2 = document.getElementsByClassName("close_login2")[0];

// When the user clicks the button, open the modal 
    btn_login1.onclick = function () {
        modal_login1.style.display = "block";
    }

// When the user clicks on <span> (x), close the modal
    span_login1.onclick = function () {
        modal_login1.style.display = "none";
    }

    span_login2.onclick = function () {
        modal_login1.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal_login1) {
            modal_login1.style.display = "none";
        }
    }
    
    });
</script>


<!-- The Modal -->
<div id="myModal_sign1" class="modal_sign1">

    <!-- Modal content -->
    <div class="modal-content_sign1">
        <span class="close_sign1">&times;</span>
        <p class="success-msg login-error" style="color:green;"></p>
        <h2>Sign Up</h2>
        {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'reg_form')) !!}
        <input type="hidden" name="_Token" value="{{ csrf_token() }}">

        <div class="user_logg" style="min-height: 60px;">
            <div class="user-input-wrp user_input_wp1 user_input_w"><br/>
                {!! Form::text('first_name',null,['class'=>'inputText', 'id'=>'first_name','required' => '']) !!}
                <span class="first_name_er error"></span>

                <span class="floating-label">First Name</span>
            </div>
            <div class="user-input-wrp user_input_wp1"><br/>
                {!! Form::text('last_name',null,['class'=>'inputText', 'id'=>'last_name','required' => '']) !!}
                <span class="last_name_er error"></span>
                <span class="floating-label">Last Name</span>
            </div>
        </div>
        <div class="user-input-wrp"><br/>
            {!! Form::text('email',null,['class'=>'inputText', 'id'=>'email_register','required' => '']) !!}
            <span class="email_register_er error"></span>
            <span class="floating-label">Email Id</span>
        </div>
         <div class="user-input-wrp"><br/>
            {!! Form::text('phone',null,['class'=>'inputText', 'id'=>'phone','required' => '']) !!}
            <span class="phone_er error"></span>
            <span class="floating-label">Mobile </span>
        </div>

        <div class="user-input-wrp pas"><br/>
            {!! Form::password('password',['class'=>'inputText', 'id'=>'password_register','required' => '']) !!}
            <span class="password_register_er error"></span>
            <span class="floating-label">Password</span>
        </div>

        <div class="user-input-wrp pas"><br/>

            {!! Form::password('confirm_password',['class'=>'inputText', 'id'=>'confirm_password','required' => '']) !!}
            <span class="confirm_password_er error"></span>
            <span class="floating-label">Confirm Password</span>
        </div>

       

        <div class="rdo">
            <label class="col-md-6 col-xs-6">Gender</label>
            <label class="container_rdo col-md-3 col-xs-3">
                {!! Form::radio('gender','Male',null,['class'=>'inputText gender', 'id'=>'gender','required' => '','checked'=>'checked' ]) !!}
                <span class="checkmark_rdo">Male</span>
            </label>
            <label class="container_rdo col-md-3 col-xs-3">

                {!! Form::radio('gender','Female',null,['class'=>'inputText gender', 'id'=>'gender','required' => '' ]) !!}
                <span class="checkmark_rdo">Female</span>
            </label>

        </div>
        <br>
        <button id="register" class="cs">Submit</button>
        {!! Form::close() !!}
    </div>
    
</div>



<style type="text/css">
@media screen and (max-width: 767px) {
        .listing_product_show_row .sticky {
  position:relative !important;

    }
}
</style>

<script>
    
        $("#register").click(function () {
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email = $("#email_register").val();
            var phone = $("#phone").val();
            var password = $("#password_register").val();
            var confirm_password = $("#confirm_password").val();
            if ($.trim(first_name) == "") {
                $('.first_name_er').text('please enter first name');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if ($.trim(last_name) == "") {
                $('.first_name_er').text('');
                $('.last_name_er').text('please enter last name');
                $('.email_register_er').text('');
                $('.phone_er').text('');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if ($.trim(email) == "") {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('please enter email');
                $('.phone_er').text('');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if (!validateEmail(email)) {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('Invalid Email Format');
                $('.phone_er').text('');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if ($.trim(phone) == "") {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('please enter phone');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if (phone.length != 10) {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('Please enter 10 digit mobile number');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if (!$('#phone').val().match('[0-9]{10}')) {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('Please put 10 digit mobile number');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if (!$('#phone').val().match('[0-9]{10}')) {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('Please put 10 digit mobile number');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
                return false;
            }else if ((password.length) < 6) {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('');
                $('.password_register_er').text('Password should atleast 6 character in length...!!!!!!');
                $('.confirm_password_er').text('');
                return false;
            } else if (!(password).match(confirm_password)) {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('');
                $('.password_register_er').text('Your passwords do not match. Try again?');
                $('.confirm_password_er').text('');
                return false;
            
            }else{
                $.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/register',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#reg_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        $('.success').addClass('su').html(msg1.message);
                        $('.success-msg').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
                        if(msg1.message=='Activate the link on email for registration complete.')
                        {
                $('.first_name_er').text('');
                $('.last_name_er').text('');
                $('.email_register_er').text('');
                $('.phone_er').text('');
                $('.password_register_er').text('');
                $('.confirm_password_er').text('');
		$("#reg_form")[0].reset();
			}
                    },
                    error: function (data) {
                    }
                });
                return false;
            }
        });


        $("#login").click(function () {
			
			var url = window.location.pathname;
            var email = $("#email").val();
            var password = $("#password").val();
            if (!validateEmail(email)) {
                $('.success-msg1').html("Invalid Email Format");
                return false;
            }
            else {
                $.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/login_post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#login_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        $('.success').addClass('su').html(msg1.message);
                        $('.success-msg1').html(msg1.message);
                        $(".loading-cntant").css("display", "none");

                        if (msg1.message == "Login Successfully") {
                            <?php if(Request::is('payment')){ ?>
                            window.location.assign("{{URL::to('/')}}")
                       <?php }else if(Request::is('success')){ ?>
                           window.location.assign("{{URL::to('/')}}")
                       <?php }else if (Request::is('guest_checkout')) { ?>
                            window.location.assign("{{URL::to('/')}}")
                    <?php }?>
                           
                            setTimeout(function () {// wait for 5 secs(2)
                               // window.location.assign("{{URL::to('/')}}")
                                window.location.assign(url)
                            }, 2000);
                        }
                        //window.location.href = {{URL::to('/')}};					

                    },
                    error: function (data) {
                    }
                });
                return false;

            }
        });

        $('#forgot_id').click(function () {
			var forgot_token = $('#forgot_token').val();
			
            $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });
            var user_name = $('#username').val();
            if (user_name == "") {
                $('.success-msg').html('Email Field Required.');
                return false;
            }else if (!validateEmail(user_name)) {
                $('.success-msg').html('Invalid Email Format');
                return false;
            }else{
            $(".loading-cntant").css("display", "block");
            $.ajax({
                type: "POST",
                url: '{{URL::to("/")}}/forgotPassword',
                data: {username: user_name, forgot_token : forgot_token},
                success: function (msg) {
                    console.log(msg);
                    msg1 = JSON.parse(msg);
                    $('.success-msg').html(msg1.message);
                    $(".loading-cntant").css("display", "none");

                },
                error: function (data) {
                }
            });
        }
        });



        $("#subscribe").click(function () {
            var email = $("#news_email").val();

            if (email == '') {
                $('.success-msg3').html("Please Enter Email");
                return false;
            } else if (!validateEmail($.trim(email))) {
                $('.success-msg3').html("Invalid Email Format");
                return false;
            }
            else {
                $.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/newsletter',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#newsletter_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);

                        $('.success-msg3').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
                        //$("#reg_form")[0].reset();
                    },
                    error: function (data) {
                    }
                });
                return false;

            }
        });

        $(document).on("click", ".wishlist_btn", function () {
           
            var url = '{{PRODUCT_IMAGE_URL}}';
            var detail_url = '{{URL::to("productDetail")}}';
            var self = this;
            console.log(self)
            $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });
            var color_id = $(this).attr("attrColor");      
            productId = $(this).attr("attrId");
            var html = [];
            $.ajax({
                type: "POST",
                url: '{{URL::to("/")}}/addwishlist',
                cache: false,
                data: {product_id: productId,
                       color_id: color_id
                      },
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);
                    $(".count_wish").removeAttr('style');
                    $(".count_wish").html(msg1.count);
                    var productlist = msg1.data;

                    $.each(msg1.data, function (key, value) {
                        console.log(value);
                        //console.log('hello',value.id);
                        html.push('<li><a href="' + detail_url + '/' + value.slug + '/'+value.color_slug+'"><img src="' + url + value.image_name + '"><h4>' + value.product_title + '</h4> <span>{!! CURRENCY !!}&nbsp;<b>' + value.price + '</b></span></a></li>');

                    });
                    $('#wishlist_dropdown').html(html);
                    /*for (var i = 0; productlist.length > i; i++) {
                     console.log('hello',productlist.id);
                     }*/
                    setTimeout(function () {
                        $(self).addClass('wishlist-btn-color');
                        $(self).addClass('wishlist_btn_red');

                    }, 0)
                    $(self).removeClass('wishlist_btn');
                },
                error: function (data) {
                }
            });
            return false;
        });

        $(document).on("click", ".wishlist_btn_red", function () {

            var url = '{{PRODUCT_IMAGE_URL}}';
            var detail_url = '{{URL::to("productDetail")}}';

            var self = this;
            console.log(self)
            $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });

            productId = $(this).attr("attrId");
            var color_id = $(this).attr("attrColor");
            //alert(color_id);
            var html = [];
            $.ajax({
                type: "POST",
                url: '{{URL::to("/")}}/removewishlist',
                cache: false,
                data: {product_id: productId,
                       color_id: color_id},
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);

                    $(".count_wish").html(msg1.count);
                    $.each(msg1.data, function (key, value) {
                        //console.log('hello',value.id);
                        html.push('<li><a href="' + detail_url + '/' + value.slug + '"><img src="' + url + value.image_name + '"><h4>' + value.product_title + '</h4> <span>{!! CURRENCY !!}&nbsp;<b>' + value.price + '</b></span></a></li>');
                    });
                    $('#wishlist_dropdown').html(html);

                    setTimeout(function () {
                        $(self).removeClass('wishlist-btn-color');
                        $(self).removeClass('wishlist_btn_red');
                        $(self).addClass('wishlist_btn');
                    }, 0)
                },
                error: function (data) {
                }
            });
            return false;
        });
 


    function validateEmail(email) {

        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) {
            return false;
        } else {
            return true;
        }
    }
</script>


<script>
	
	$( document ).ready(function() {
// Get the modal
    var modal_sign1 = document.getElementById('myModal_sign1');

// Get the button that opens the modal
    var btn_sign1 = document.getElementById("myBtn_sign1");

// Get the <span> element that closes the modal
    var span_sign1 = document.getElementsByClassName("close_sign1")[0];

// When the user clicks the button, open the modal 
    btn_sign1.onclick = function () {
        modal_sign1.style.display = "block";
    }

// When the user clicks on <span> (x), close the modal
    span_sign1.onclick = function () {
        modal_sign1.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal_sign1) {
            modal_sign1.style.display = "block";
        }
    }
    
    });
</script>
<script>
    $('#demo_2 input').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#demo_2').submit();
    }
});
</script>
{!! Html::script( asset('js/plugins.js')) !!}
{!! Html::script( asset('js/active.min.js')) !!}



