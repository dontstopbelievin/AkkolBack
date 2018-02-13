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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('token', 'Auth\AccessTokenController@issueToken');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@create'])->middleware('cors');

Route::group(['middleware' => 'auth:api'], function ()
{
    Route::group(['prefix' => '/apz'], function() {
        Route::get('/', 'ApzController@index');
    });

    Route::group(['prefix' => '/file'], function() {
        Route::get('/', 'FileController@index');
        Route::post('upload', 'FileController@upload');
    });

    Route::group(['prefix' => '/photoreport'], function() {
        Route::get('/', 'PhotoReportController@index');
        Route::post('create', 'PhotoReport@create');
        Route::post('response', 'PhotoReport@response');
        Route::post('personal', 'PhotoReport@personal');
    });
});