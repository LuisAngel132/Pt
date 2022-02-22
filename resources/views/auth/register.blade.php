@extends('template.interno')

@section('contenido')
<style>
/* The container */
.container-radio-register {
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
.container-radio-register input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark-radio {
  position: absolute;
  top: 2px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border: 1px solid #24bddf;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container-radio-register:hover input ~ .checkmark-radio {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container-radio-register input:checked ~ .checkmark-radio {
  background-color: #24bddf;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark-radio:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-radio-register input:checked ~ .checkmark-radio:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container-radio-register .checkmark-radio:after {
  top: 5px;
  left: 5px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

/*Checkbox*/
/* The container */
.container-check-register {
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
.container-check-register input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark-check {
  position: absolute;
  top: 25px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border: 1px solid #24bddf;
}

/* On mouse-over, add a grey background color */
.container-check-register:hover input ~ .checkmark-check {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container-check-register input:checked ~ .checkmark-check {
  background-color: #24bddf;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark-check:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-check-register input:checked ~ .checkmark-check:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container-check-register .checkmark-check:after {
  top: 5px;
  left: 5px;
  width: 8px;
  height: 8px;
  background: white;
}
</style>
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li class="active"><b>@lang('lang.register')</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>
<!--Breadcrumb End-->
<!--Login Area Strat-->
<div class="login-area pt-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-12 col-lg-6 col-xl-6 ml-auto mr-auto">
        <div class="login">
          <div class="login-form-container form-auth">
            <div class="login-form">
              @if ($errors->any())
              <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>@lang('lang.alert_warning')</strong>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
              </div>
              @endif
              <form id="form-register" method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                @csrf
                <p>@lang('lang.register_have_account')<a href="login"> @lang('lang.register_Login_instead')</a></p>
                <label>@lang('lang.register_name_form')</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
                <label>@lang('lang.register_last_name_form')</label>
                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
                <label>@lang('lang.register_genero')</label>
                <div class="input-radio">
                  <label class="container-radio-register">
                    <input name="gender" value="1" type="radio"> M
                    <span class="checkmark-radio"></span>
                  </label>
                  <label class="container-radio-register">
                    <input name="gender" value="0" type="radio"> F
                    <span class="checkmark-radio"></span>
                  </label>
                </div>
                <label>@lang('lang.register_email_form')</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
                <label>@lang('lang.register_phone_form')</label>
                <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required maxlength="10" size="10">
                @if ($errors->has('phone_number'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
                @endif
                <label>@lang('lang.register_password_form')</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
                <label>@lang('lang.register_password_confirm_form')</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                <label class="custom-checkbox container-check-register">
                  <input name="terms_and_conditions" value="1" type="checkbox" required>
                  <span class="checkmark-check"></span>
                  <a href="about"> @lang('lang.register_conditions')</a>
                </label>
                <div class="button-box">
                  <input value="@lang('lang.register_btn')" type="submit" class="default-btn">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Login Area End-->

@endsection

@section('js')
@endsection
