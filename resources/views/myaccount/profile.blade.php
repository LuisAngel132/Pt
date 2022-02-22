@extends('template.interno')
@section('css-plugin')
  <meta name="token" content="{{ Session::get('token') }}">
  <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
  <link href="css/magnific-popup.css" rel="stylesheet">
@endsection
@section('contenido')
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li><b>@lang('lang.myaccount')</b></li>
           <li class="active"><b>@lang('lang.profile')</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>
<!--Breadcrumb End-->
<div class="pt-20">
  <div class="container">
    <!--Section Profile-->
    @include('myaccount.personal')
    <!--End Section Profile-->
    <!--Section Card-->
    @include('myaccount.card')
    <!--End Section Card-->
    <!--Section Address-->
    @include('myaccount.address')
    <!--End Section Address-->
  </div>
</div>
@endsection
@section('js')
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.magnific-popup-init.js"></script>
<script src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<script src="js/script/js-account.js"></script>
@endsection
