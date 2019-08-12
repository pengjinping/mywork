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
Route::get( '/test', function (){
	return view("index");
});

Route::get( '/', "IndexController@index" );
Route::get( '/addForm/{id}', "IndexController@addForm" );
Route::post( '/addList', "IndexController@addList" );

Route::group( ['prefix' => 'product'], function () {
	Route::get( '/{id?}', "ProductController@index" )->where( ["id" => '[0-9]+'] );
    Route::get( '/add', "ProductController@add" );
	Route::get( '/list/{code?}', "ProductController@list" );
	Route::get( '/addForm/{code}', "ProductController@addForm" );
	Route::post( '/addList', "ProductController@addList" );
} );

