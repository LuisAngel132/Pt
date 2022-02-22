@extends('template.interno')
@section('contenido')
@section('css-plugin')
@endsection
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
             <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
             <li class="active"><b>@lang('lang.about')</b></li>
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
        <div class="col-lg-12 col-12">
            <!--About Us Content Start-->
            <div class="about-us-content">
                <h2 class="name-company" style="text-transform: initial !important;"></h2>
                <p class="mb-20 description-company"></p>
            </div>
            <!--About Us Content End-->
        </div>
    </div>
    <br>
    <div class="row" style="text-align: justify;">
      <div class="col-lg-6 col-12">
        <div class="section-title section-title-left mb-50">
          <h2>@lang('lang.terms')</h2>
          <p class="link-terms"></p>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <div class="section-title section-title-left mb-50">
          <h2>@lang('lang.privacy')</h2>
          <p class="link-privacy"></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="js/javascript/about.js"></script>
@endsection
