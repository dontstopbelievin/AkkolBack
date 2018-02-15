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
Route::get('/user_info', 'Auth\LoginController@userInfo');


Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => '/apz'], function () {
        Route::group(['middleware' => 'role:citizen'], function () {
            Route::post('/Create', 'ApzController@create');
            Route::get('/user', 'ApzController@getApzByUser');
            Route::get('/detail/{id}', 'ApzController@getApzDetail');
        });

        Route::group(['middleware' => 'role:region'], function () {
            Route::get('/region', 'ApzController@getApzByRegion');
        });
    });

    Route::group(['prefix' => '/file'], function () {
        Route::get('/', 'FileController@index');
        Route::get('all', 'FileController@all');
        Route::get('categoriesList', 'FileController@categoriesList');
        Route::get('download/{id}', 'FileController@download');
        Route::post('upload', 'FileController@upload');
    });

    Route::group(['prefix' => '/photoreport'], function () {
        Route::get('/', 'PhotoReportController@index');
        Route::post('create', 'PhotoReport@create');
        Route::post('response', 'PhotoReport@response');
        Route::post('personal', 'PhotoReport@personal');
    });
});