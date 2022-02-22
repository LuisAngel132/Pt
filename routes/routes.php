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
Route::resource('postContact', 'Contact\ContactController'); /*Form Contact*/
Route::group(['middleware' => ['auth']], function () {
    /*Shopping History*/
    Route::resource('shopping-history', 'ShoppingHistory\ShoppingHistoryController');
    Route::post('getShoppingHistory', 'ShoppingHistory\ShoppingHistoryController@getData');
    Route::post('postCancel', 'ShoppingHistory\ShoppingHistoryController@postCancel');
    Route::post('postDevolution', 'ShoppingHistory\ShoppingHistoryController@postDevolution');
    Route::get('getReference', 'ShoppingHistory\ShoppingHistoryController@getReference');
    Route::post('getProducts', 'ShoppingHistory\ShoppingHistoryController@getProducts');
    Route::get('getDetail', 'ShoppingHistory\ShoppingHistoryController@getDetail');
    Route::get('getTraking', 'ShoppingHistory\ShoppingHistoryController@getTraking');
    Route::post('getResource', 'ShoppingHistory\ShoppingHistoryController@getResource');
    Route::get('detailProduct', 'ShoppingHistory\ShoppingHistoryController@detailProduct');

    /*Favorites*/
    Route::resource('favorites', 'Favorites\FavoritesController');
    Route::get('like', 'Favorites\FavoritesController@like');

    /*Cards*/
    Route::resource('cards', 'Cards\CardsController');
    Route::get('getCards', 'Cards\CardsController@getCards');
    Route::get('delete-card/{id}', 'Cards\CardsController@deleteCard');
});
/*About*/
Route::resource('about', 'About\AboutController');
Route::get('faqs', 'About\AboutController@viewFaqs');
Route::get('getCompany', 'About\AboutController@getCompany');
Route::get('getFaqs', 'About\AboutController@getFaqs');
