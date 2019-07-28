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

Route::get('/', 'IndexController@index');
Route::get('/c/{category_name}_{category_id}', 'IndexController@index');

Route::view('/fail', 'web.fail');

Route::get('/product/{id}', 'ProductController@index');
Route::any('/wishlist', 'ProductController@wishlist');
Route::post('/review', 'ProductController@review');
Route::get('/p/{category_name}_{category_id}/{seo}.html', 'ProductController@index');

Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/', 'AccountController@index')->name('account');
    Route::any('/edit', 'AccountController@edit')->name('account.edit');
    Route::any('/password', 'AccountController@password')->name('account.password');
    Route::get('/wishlist', 'AccountController@wishlist')->name('account.wishlist');
    Route::get('/wishlist/delete', 'AccountController@deleteWishlist')->name('account.wishlist.delete');
    Route::get('/address', 'AccountController@address')->name('account.address');
    Route::any('/address/set', 'AccountController@setAddress')->name('account.address.set');
    Route::any('/address/delete/{id}', 'AccountController@deleteAddress')->name('account.address.delete');
    Route::get('/orders', 'AccountController@orders')->name('account.orders');
    Route::get('/order/cancel/{id}', 'AccountController@cancelOrder')->name('account.order.cancel');
    Route::get('/order/detail/{id}', 'AccountController@orderDetail')->name('account.order.detail');
});

Route::get('/cart', 'CartController@index')->name('cart');
Route::any('/cart/update', 'CartController@update')->name('cart.update');
Route::any('/cart/remove', 'CartController@remove')->name('cart.remove');
Route::any('/cart/refresh', 'CartController@refresh')->name('cart.refresh');

Route::prefix('checkout')->group(function () {
    Route::get('/', 'CheckoutController@index')->name('checkout');
    Route::post('/step1', 'CheckoutController@step1')->name('checkout.step1');
    Route::post('/step2', 'CheckoutController@step2')->name('checkout.step2');
    Route::post('/step3', 'CheckoutController@step3')->name('checkout.step3');
    Route::post('/confirm', 'CheckoutController@confirm')->name('checkout.confirm');
    Route::get('/done', 'CheckoutController@done')->name('checkout.done');
    Route::get('/fail', 'CheckoutController@fail')->name('checkout.fail');
});

Route::prefix('payment')->group(function () {
    Route::any('/handle', 'PaymentController@handle')->name('payment.handle');
    Route::get('/detail/{id}', 'PaymentController@index');
});

Route::get('/{seo}.html', 'PageController@index');

Route::any('/currency', 'SessionController@setCurrency');

Route::get('/sitemap', 'IndexController@sitemap');

Route::get('/sitemap.xml', 'IndexController@sitemapXML');

Route::get('/quickpay', 'QuickPayController@index')->name('quickpay');

Route::get('/tracking', 'TrackingController@index')->name('tracking');
