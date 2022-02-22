@extends('template.interno')
@section('contenido')
@section('css-plugin')
@endsection
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-50 pb-50">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
             <li><a href="/">@lang('lang.menu_home')</a></li>
             <li><a href="#">@lang('lang.myaccount')</a></li>
             <li class="active"><a href="shopping-history">@lang('lang.shopping_history')</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Breadcrumb End-->
<div class="login-area pt-90">
  <div class="container">
    <div class="row">
        <div class="col-lg-12 col-12">
          <iframe src="{{ $reference }}" style="width:100%; height:500px;" frameborder="0"></iframe>
        </div>
    </div>
  </div>
</div>
@endsection
@section('js')
@endsection
