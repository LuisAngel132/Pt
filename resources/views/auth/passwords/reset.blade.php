@extends('template.interno')

@section('contenido')
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
       <div class="col-md-12">
         <div class="breadcrumb-content">
           <ul>
             <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
             <li class="active"><b>@lang('lang.reset')</b></li>
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
              <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <label>@lang('lang.reset_email_form')</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <label>@lang('lang.reset_password_form')</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <label>@lang('lang.reset_password_confirm_form')</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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

@endsection
