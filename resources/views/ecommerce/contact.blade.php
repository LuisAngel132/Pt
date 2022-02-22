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
                       <li class="active"><b>@lang('lang.contact')</b></li>
                   </ul>
               </div>
           </div>
       </div>
   </div>
</div>
<!--Breadcrumb End-->
<!--Contact Us Area Start-->
<div class="contact-us-area pt-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="store-information">
                    <div class="store-title">
                        <h4>@lang('lang.information')   </h4>
                        <div class="communication-info">
                            <!--Single Communication Start-->
                            <div class="single-communication">
                                <div class="communication-icon">
                                    <i class="zmdi zmdi-pin"></i>
                                </div>
                                <div class="communication-text">
                                    <span>Av. Juárez #146 3er piso int-304, Col. Centro<br>Torreón, Coahuila, México. <br>C.P. 27000</span>
                                </div>
                            </div>
                            <!--Single Communication End-->
                            <!--Single Communication Start-->
                            <div class="single-communication">
                                <div class="communication-icon">
                                    <i class="zmdi zmdi-phone"></i>
                                </div>
                                <div class="communication-text">
                                    <span><a href="tel:8001234567">+52 (871) 716 7296</a></span>
                                </div>
                            </div>
                            <!--Single Communication End-->
                            <!--Single Communication Start-->
                            <div class="single-communication">
                                <div class="communication-icon">
                                    <i class="zmdi zmdi-email"></i>
                                </div>
                                <div class="communication-text">
                                    <span><a href="mailto:contacto@phara.shop">contacto@phara.shop</a></span>
                                </div>
                            </div>
                            <!--Single Communication End-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="content-wrapper">
                    <div class="page-content">
                        <div class="contact-form">
                            <div class="contact-form-title">
                                <h3>@lang('lang.contact') </h3>
                            </div>
                            @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ Session::get('success') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           {{ Session::get('error') }}
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     @endif
                     <form action="postContact" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="contact-form-style mb-20">
                                    <input name="name" placeholder="@lang('lang.full_name_form')" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="contact-form-style mb-20">
                                    <input name="email" placeholder="@lang('lang.email_form')" type="email" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="contact-form-style mb-20">
                                    <input name="subject" placeholder="@lang('lang.subject_form')" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="contact-form-style">
                                    <textarea name="message" placeholder="@lang('lang.message_form')" required></textarea>
                                    <button class="default-btn" type="submit"><span style="color: white;">@lang('lang.send_message') </span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!--Contact Us Area End-->
@endsection
