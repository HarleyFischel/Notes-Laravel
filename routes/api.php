<?php

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

Route::get('/token', 'ApiController@token');
Route::get('/', 'ApiController@index');
Route::get('/{id}', 'ApiController@get');
Route::put('/', 'ApiController@insert');
Route::post('/', 'ApiController@update');
Route::delete('/{id}', 'ApiController@delete');
