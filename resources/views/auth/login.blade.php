@extends('template.interno')

@section('contenido')
<style>
/* The container */
.container-check {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container-check input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark-login {
  position: absolute;
  top: 2px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border: 1px solid #24bddf;
}

/* On mouse-over, add a grey background color */
.container-check:hover input ~ .checkmark-login {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container-check input:checked ~ .checkmark-login {
  background-color: #24bddf;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark-login:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-check input:checked ~ .checkmark-login:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container-check .checkmark-login:after {
  top: 5px;
  left: 5px;
  width: 8px;
  height: 8px;
  background: white;
}
</style>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '241320893186944',
      cookie     : true,
      xfbml      : true,
      version    : '3.1'
    });

    FB.AppEvents.logPageView();

  };

  (function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "https://connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));
</script>
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
     <div class="col-md-12">
       <div class="breadcrumb-content">
         <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li class="active"><b>Login</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>
<!--Breadcrumb End-->

<div class="login-area pt-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-12 col-lg-6 col-xl-6 ml-auto mr-auto">
        <div class="login">
          <div class="login-form-container form-auth">
            <div class="login-form">
             @if(Session::has('Error_Social'))
             <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <h4>@lang('lang.profile_alert_error_title')</h4>
              @foreach(Session::get('Error_Social') as $loginUser)
              <p>{{$loginUser}}</p>
              @endforeach
            </div>
            @endif
            @if(Session::has('Error'))
            <div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <h4>@lang('lang.login_alert_error_title')</h4>
              <p>@lang('lang.login_alert_error')</p>
            </div>
            @endif
            @if(Session::has('Nofound_customer'))
            <div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <h4>@lang('lang.login_alert_error_title')</h4>
              <p>@lang('lang.login_alert_error_customer_nofound')</p>
            </div>
            @endif
            <form method="POST" action="login" aria-label="{{ __('Login') }}">
              @csrf
              <label>@lang('lang.login_email')</label>
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
              @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
              <label>@lang('lang.login_password')</label>
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

              @if ($errors->has('password'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
              <div class="button-box">
                <div class="login-toggle-btn">
                  <label class="container-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    @lang('lang.login_remember')
                    <span class="checkmark-login"></span>
                  </label>
                  <a class="btn btn-link" href="{{ route('password.request') }}"> @lang('lang.login_forget_password')</a>
                </div>
                      <!--button type="submit" class="default-btn">
                      {{ __('Login') }}
                    </button-->
                    <input value="{{ __('Login') }}" type="submit" class="default-btn">
                    <br>
                    <div class="login-social">
                      <a class="btn btn-block btn-social btn-facebook" href="login/facebook">
                        <span class="fa fa-facebook"></span> |Sign in with Facebook
                      </a>
                      <a class="btn btn-block btn-social btn-twitter" href="login/twitter">
                       <span class="fa fa-twitter"></span> |Sign in with Twitter
                     </a>
                   </div>

                 </div>
               </form>
               <div class="no-account">
                <a href="{{ url('/register') }}"">@lang('lang.login_no_account')</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
