@extends('template.interno')
@section('contenido')
@section('css-plugin')
<style>
  .faqs{
    width: 100%;
    height: 150px;
    margin-top: 15px;
    margin-bottom: 15px;
  }
</style>
@endsection
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
             <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
             <li class="active"><b>Faqs</b></li>
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
      <div class="col-md-12">
        <!--Section Title Start-->
        <div class="section-title section-title-left mb-50">
          <h2>FAQS</h2>
        </div>
        <!--Section Title End-->
        <div class="faq-accordion">
            <div id="accordion">
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="js/javascript/about.js"></script>
@endsection
