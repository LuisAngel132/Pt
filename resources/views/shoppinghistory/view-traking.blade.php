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
           <li><a href="shopping-history"><b>@lang('lang.shopping_history')</b></a></li>
           <li class="active"><b>@lang('lang.tracking')</b></li>
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
        <h3>@lang('lang.tracking')</h3><br>
        <b>@lang('lang.reference_tracking_id'):</b><p>{{ $reference }}</p>
        <div class="table-content table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>@lang('lang.date')</th>
                <th>@lang('lang.time')</th>
                <th>@lang('lang.description')</th>
                <th>@lang('lang.location')</th>
              </tr>
            </thead>
            <tbody>

              @foreach($traking as $location)
              <tr>
               <td>{{ $location['date'] }}</td>
               <td>{{ $location['time'] }}</td>
               <td>{{ $location['description'] }}</td>
               <td>{{ $location['location'] }}</td>
             </tr>
             @endforeach

           </tbody>
         </table>
       </div>
     </div>
   </div>
 </div>
</div>
@endsection
@section('js')
@endsection
