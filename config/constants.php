<?php
return [
    'API_URL'                => config('services.paypal'),
    'BASE_URL'               => config('app.env') == 'production' ? env('PRODUCTION_BASE_URL') : env('SANDBOX_BASE_URL', ''),
    'BASE_ECOMERCE_URL'      => config('app.env') == 'production' ? env('PRODUCTION_BASE_ECOMERCE_URL') : env('SANDBOX_BASE_ECOMERCE_URL'),
    'AUTH_LOGIN'             => '/v1/auth/login',
    'AUTH_LOGIN_SOCIAL'      => '/v1/auth/login/social',
    'AUTH_REGISTER_SOCIAL'   => '/v1/auth/register/social',
    'AUTH_REGISTER'          => '/v1/auth/register',
    'CART_GET'               => '/v1/cart',
    'RESOURCES_FAQS'         => '/v1/resources/faqs',
    'RESOURCES_COMPANY'      => '/v1/resources/company',
    'PAYMENTS_CARDS'         => '/v1/cards',
    'COUPONS_VALIDATE'       => '/v1/coupons/',
    'ORDERS'                 => '/v1/orders',
    'LIKES'                  => '/v1/likes',
    'RESOURCES_ORDER_STATUS' => '/v1/resources/order-status',
    'paypal_enviroment'      => config('app.env') == 'production' ? 'production' : 'sandbox',
];
