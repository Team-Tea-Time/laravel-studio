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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tokens/create/{name?}', function (\Illuminate\Http\Request $request, $name = 'test') {
    $token = $request->user()->createToken($name);

    return ['token' => $token->plainTextToken];
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
