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

// Authentification
Auth::routes([
    'register' => true,
    'verify' => true,
    'reset' => true
]);
  
Route::redirect('/', '/home', 301);
Route::get('about', 'Frontend\HomeController@about')->name('public.about');
Route::get('home', 'Frontend\HomeController@index')->name('home');
Route::get('map', 'Frontend\HomeController@map')->name('public.map.index');
Route::get('country/{cca3}', 'Frontend\CountryController@show')->name('public.country.show');
Route::get('category/{slug}', 'Frontend\CategoryController@show')->name('public.category.show');

// Addresses
Route::get('addresses/json', 'API\AddressController@json')->name('api.addresses.json');
Route::get('addresses/geojson', 'API\AddressController@geojson')->name('api.addresses.geojson');
// Categories
Route::get('categories/autocomplete', 'API\CategoryController@autocomplete')->name('api.categories.autocomplete');
Route::get('categories/json', 'API\CategoryController@json')->name('api.addresses.json');
// Countries
Route::get('countries/autocomplete', 'API\CountryController@autocomplete')->name('api.countries.autocomplete');
Route::get('countries/geojson/{cca3?}', 'API\CountryController@geojson')->name('api.countries.geojson');

// Administration    
Route::middleware('auth')->group(function () {
    // Administration
    Route::get('approval', 'Admin\UserController@approval')->name('auth.approval');
    
    Route::middleware(['approved'])->group(function () {
        Route::get('admin', 'Admin\AdminController@index')->name('admin.index');
    
        // Categories
        Route::post('admin/categories/import', 'Admin\CategoryController@import')->name('admin.category.import');
        Route::post('admin/categories/store', 'Admin\CategoryController@store')->name('admin.category.store');
        Route::get('admin/categories/show/{uuid}', 'Admin\CategoryController@show')->name('admin.category.show');
        Route::get('admin/categories/edit/{uuid}', 'Admin\CategoryController@edit')->name('admin.category.edit');
        Route::post('admin/categories/update', 'Admin\CategoryController@update')->name('admin.category.update');
        Route::post('admin/categories/delete', 'Admin\CategoryController@delete')->name('admin.category.delete');
        Route::post('admin/categories/restore', 'Admin\CategoryController@restore')->name('admin.category.restore');
        Route::get('admin/categories/{q?}', 'Admin\CategoryController@index')->name('admin.category.index');
        Route::post('admin/categories/{q?}', 'Admin\CategoryController@index')->name('admin.category.search');
    
        // Countries
        Route::get('admin/countries/show/{cca3}', 'Admin\CountryController@show')->name('admin.country.show');
        Route::get('admin/countries/{q?}', 'Admin\CountryController@index')->name('admin.country.index');
        Route::post('admin/countries/{q?}', 'Admin\CountryController@index')->name('admin.country.search');
    
        // Addresses
        Route::post('admin/addresses/import', 'Admin\AddressController@import')->name('admin.address.import');
        Route::get('admin/addresses/new/{uuid?}', 'Admin\AddressController@create')->name('admin.address.create');
        Route::post('admin/addresses/store', 'Admin\AddressController@store')->name('admin.address.store');
        Route::get('admin/addresses/show/{uuid}', 'Admin\AddressController@show')->name('admin.address.show');
        Route::get('admin/addresses/edit/{uuid}', 'Admin\AddressController@edit')->name('admin.address.edit');
        Route::post('admin/addresses/update/', 'Admin\AddressController@update')->name('admin.address.update');
        Route::post('admin/addresses/delete/', 'Admin\AddressController@delete')->name('admin.address.delete');
        Route::post('admin/addresses/restore/', 'Admin\AddressController@restore')->name('admin.address.restore');
        Route::get('admin/addresses/{q?}', 'Admin\AddressController@index')->name('admin.address.index');
        Route::post('admin/addresses/{q?}', 'Admin\AddressController@index')->name('admin.address.search');
    
        // Users
        Route::get('admin/activity/', 'Admin\UserController@activity')->name('admin.activity.index');
        Route::get('admin/users/', 'Admin\UserController@index')->name('admin.user.index');
        Route::post('admin/users', 'Admin\UserController@index')->name('admin.user.search');
        Route::get('admin/users/approve/{uuid}', 'Admin\UserController@approve')->name('admin.user.approve');
        Route::get('admin/users/disapprove/{uuid}', 'Admin\UserController@disapprove')->name('admin.user.disapprove');
        Route::get('admin/users/show/{uuid}', 'Admin\UserController@show')->name('admin.user.show');
        Route::get('admin/users/edit/{uuid}', 'Admin\UserController@edit')->name('admin.user.edit');
        Route::post('admin/users/update', 'Admin\UserController@update')->name('admin.user.update');
        Route::post('admin/users/role', 'Admin\UserController@role')->name('admin.user.role');
        Route::post('admin/users/delete', 'Admin\UserController@delete')->name('admin.user.delete');
        Route::post('admin/users/restore', 'Admin\UserController@restore')->name('admin.user.restore');
        
        // Export
        Route::get('admin/export/addresses/doc/{type}',   'Admin\ExportController@doc_addresses')->name('admin.export.doc.addresses')->where('type', '(docx|odt|html)');
        Route::get('admin/export/addresses/xls/{type}',   'Admin\ExportController@xls_addresses')->name('admin.export.xls.addresses')->where('type', '(xlsx|csv|ods|html)');
        Route::get('admin/export/categories/xls/{type}',  'Admin\ExportController@xls_categories')->name('admin.export.xls.categories')->where('type', '(xlsx|csv|ods|html)');
        Route::get('admin/export/countries/xls/{type}',   'Admin\ExportController@xls_countries')->name('admin.export.xls.countries')->where('type', '(xlsx|csv|ods|html)');
    });
});