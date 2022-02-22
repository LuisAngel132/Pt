<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Localization
Route::get('js/lang.js', function () {

    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo ('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');
/**
 * get lang
 */
Route::get('lang/{lang}', function ($lang) {
    \Session::put('lang', $lang);
    return \Redirect::back();
})->middleware('web')->name('change_lang');

Route::group(['middleware' => ['web']], function () {
    /*login web service*/
    Route::post('login', 'Auth\LoginController@login');
    Route::get('get_token_login', 'Auth\LoginController@getTokenLogin');

    Route::get('login/facebook', 'Social\SocialAuthController@redirectToProvider');
    Route::get('login/facebook/callback', 'Social\SocialAuthController@handleProviderCallbackFromFacebook');

    Route::get('login/twitter', 'Social\SocialAuthController@redirectToProviderTwitter');
    Route::get('login/twitter/callback', 'Social\SocialAuthController@handleProviderCallbackFromTwitter');
    Auth::routes();

    Route::get('contact', function () {
        return view('ecommerce.contact');
    });

    Route::resource('/', 'Index\IndexController');
    Route::get('search-product/{id}', 'Index\IndexController@searchProduct');
    Route::resource('design', 'Design\DesignController');
    Route::get('get_designs', 'Design\DesignController@getDesigns');
    /*Category*/
    Route::resource('category', 'Category\CategoryController');
    Route::get('get_category', 'Category\CategoryController@getCategory');
    Route::get('get_gender', 'Category\CategoryController@getGender');
    Route::get('get_style', 'Category\CategoryController@getStyle');
    Route::get('get_size/{id}', 'Category\CategoryController@getSize');
    /*cart*/
    Route::resource('cart', 'Cart\CartController');
    Route::get('get_cart', 'Cart\CartController@getCart');
    Route::get('get_cart_shop', 'Cart\CartController@getCartShop');
    Route::post('cart_update', 'Cart\CartController@cartUpdate');
    Route::get('verify_stock/{products_id}/{colors_id}/{sizes_id}/{qty}', 'Cart\CartController@verifyStock');
    /*product*/
    Route::resource('product', 'Product\ProductController');
    Route::get('product-detail', 'Product\ProductController@getDetailProduct');
    Route::post('change_color_active', 'Product\ProductController@changeColorActive');
    /*with Login*/
    Route::group(['middleware' => ['auth']], function () {
        /*profile*/
        Route::resource('profile', 'MyAccount\ProfileController');
        Route::get('get_account', 'MyAccount\ProfileController@getCustomer');
        Route::post('update', 'MyAccount\ProfileController@updateInfo');
        Route::post('update_img', 'MyAccount\ProfileController@updateImg');
        /*address*/
        Route::get('get_address_type', 'MyAccount\AddressController@getAddressType');
        Route::get('get_address', 'MyAccount\AddressController@getAddress');
        Route::resource('address', 'MyAccount\AddressController');
        Route::post('address/edit', 'MyAccount\AddressController@editAddress');
        /*Route::post('address', 'MyAccount\AddressController@store');
        Route::post('address/edit', 'MyAccount\AddressController@editAddress');
        Route::get('address/delete', 'MyAccount\AddressController@delete');*/

        Route::resource('checkout', 'Summary\CheckoutController');
        Route::get('checkout_address_type', 'Summary\CheckoutController@getAddressType');
        Route::get('checkout_address', 'Summary\CheckoutController@getAddress');

        /*Route::get('get_total', 'Summary\CheckoutController@getTotal');
        Route::get('get_envio_final', 'Summary\CheckoutController@getEnvio');
         */
        Route::get('get_fees', 'Summary\CheckoutController@getFees');
        Route::get('get_payment_type', 'Summary\CheckoutController@getPaymentType');

        Route::post('cupon', 'Cart\CouponController@cupon');
        Route::get('get_descount', 'Cart\SummaryController@getDescount');
        Route::get('get_envio', 'Cart\SummaryController@getEnvio');
        Route::post('gifs', 'Cart\GiftController@addGift');
        Route::get('get_gifs', 'Cart\SummaryController@getGift');
        Route::get('get_total_order', 'Cart\SummaryController@getTotal');
        Route::post('new_address_order', 'Cart\SummaryController@neworderAddress');
        Route::post('summary', 'Cart\SummaryController@summary');
        Route::post('summary_paypal', 'Cart\PaypalController@summaryPaypal');
        Route::post('summary_card', 'Cart\SummaryCardController@summaryCard');
        Route::get('get_card', 'Cart\SummaryController@getCard');

        Route::resource('rating', 'ShoppingHistory\RatingController')->only([
            'store', 'update', 'destroy',
        ]);
        Route::post('rating', 'ShoppingHistory\RatingController@store');
        Route::post('get_rating', 'ShoppingHistory\RatingController@ratingCustomers');

        Route::get('valSession', 'Summary\SummaryController@totalSummary');
        Route::get('cupon_true', 'Cart\CouponController@cuponTrue');

    });
});
