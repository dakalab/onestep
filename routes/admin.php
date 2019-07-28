<?php

Route::get('/', 'IndexController@index');
Route::view('/ok', 'admin.ok');
Route::view('/fail', 'admin.fail');

Route::get('/user/list', 'UserController@getList');
Route::any('/user/profile', 'UserController@profile');
Route::get('/user/delete/{id}', 'UserController@delete');

Route::get('/photo/list', 'PhotoController@getList');
Route::post('/photo/upload', 'PhotoController@upload');
Route::get('/photo/delete', 'PhotoController@delete')->name('admin.photo.delete');
Route::get('/photo/view/{id}', 'PhotoController@view');

Route::get('/category/list', 'CategoryController@getList');
Route::any('/category/set', 'CategoryController@set');
Route::get('/category/delete/{id}', 'CategoryController@delete');

Route::get('/product/list', 'ProductController@getList');
Route::any('/product/set', 'ProductController@set');
Route::get('/product/stop/{id}', 'ProductController@stop');
Route::get('/product/delete/{id}', 'ProductController@delete');
Route::any('/product/photos/{id}', 'ProductController@getPhotos');
Route::any('/product/import', 'ProductController@import');

Route::get('/attribute/list', 'AttributeController@getList');
Route::any('/attribute/set', 'AttributeController@set');
Route::get('/attribute/delete/{id}', 'AttributeController@delete');
Route::get('/attribute/groups', 'AttributeController@getGroups');
Route::any('/attribute/set-group', 'AttributeController@setGroup');
Route::get('/attribute/delete-group/{id}', 'AttributeController@deleteGroup');

Route::get('/stock/list/{id}', 'StockController@getList');
Route::any('/stock/set/{id}', 'StockController@set');
Route::get('/stock/check', 'StockController@check');
Route::any('/stock/edit/{id}', 'StockController@edit');

Route::get('/banner/list', 'BannerController@getList');
Route::any('/banner/set', 'BannerController@set');
Route::get('/banner/delete/{id}', 'BannerController@delete');

Route::get('/review/list', 'ReviewController@getList');
Route::any('/review/set', 'ReviewController@set');
Route::get('/review/delete/{id}', 'ReviewController@delete');

Route::get('/address/list', 'AddressController@getList');
Route::any('/address/set', 'AddressController@set');
Route::get('/address/delete/{id}', 'AddressController@delete');

Route::get('/order/list', 'OrderController@getList');
Route::get('/order/view/{id}', 'OrderController@view');
Route::get('/order/cancel/{id}', 'OrderController@cancel');
Route::any('/order/edit/{id}', 'OrderController@edit');
Route::any('/order/shipping/{id}', 'OrderController@shipping');
Route::any('/order/pay/{id}', 'OrderController@pay');
Route::any('/order/tracking/{id}', 'OrderController@tracking');
Route::any('/order/product/{id}', 'OrderController@product');
Route::any('/order/product-add', 'OrderController@addProduct');
Route::any('/order/product-edit', 'OrderController@editProduct');
Route::any('/order/product-delete/{id}', 'OrderController@deleteProduct');
Route::get('/order/temp', 'OrderController@getTemp');
Route::any('/order/recover/{id}', 'OrderController@recover');

Route::any('/setting/paypal', 'SettingController@paypal');
Route::any('/setting/tracking', 'SettingController@tracking');
Route::any('/setting/index', 'SettingController@index');
Route::any('/setting/terms', 'SettingController@terms');

Route::get('/page/list', 'PageController@getList');
Route::any('/page/set', 'PageController@set');
Route::get('/page/delete/{id}', 'PageController@delete');

Route::get('/page-category/list', 'PageCategoryController@getList');
Route::any('/page-category/set', 'PageCategoryController@set');
Route::get('/page-category/delete/{id}', 'PageCategoryController@delete');
