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
              @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
              @endif
              <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                @csrf
                <label>@lang('lang.reset_email_form')</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
                <div class="button-box">
                  <input value="@lang('lang.reset_btn')" type="submit" class="default-btn">
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
