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

Route::get('/notes', function () { return view('static'); });
Route::get('/notes/{id}', function ($id) { return view('static',['id'=>$id]); });
Route::get('/react', function () { return view('react'); });
Route::get('/react/{id}', function ($id) { return view('react',['id'=>$id]); });

Route::get('/', 'NotesController@index');
Route::get('/new', 'NotesController@add');
Route::get('/edit/{id}', 'NotesController@edit');
Route::get('/{id}', 'NotesController@view');
Route::get('/delete/{id}', 'NotesController@delete');
Route::post('/', 'NotesController@save');

