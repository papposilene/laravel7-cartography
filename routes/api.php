<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    //// Addresses
    //Route::get('addresses/json',            'API\AddressController@json')->name('api.addresses.json');
    //Route::get('addresses/geojson',         'API\AddressController@geojson')->name('api.addresses.geojson');
    //
    //// Categories
    //Route::get('categories/autocomplete',   'API\CategoryController@autocomplete')->name('api.categories.autocomplete');
    //Route::get('categories/json',           'API\CategoryController@json')->name('api.addresses.json');
    //
    //// Countries
    //Route::get('countries/autocomplete',    'API\CountryController@autocomplete')->name('api.countries.autocomplete');
    //Route::get('countries/geojson/{cca3?}', 'API\CountryController@geojson')->name('api.countries.geojson');
});