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
            Route::post('/Create', 'Apz\ApzCitizenController@create');
            Route::get('/user', 'Apz\ApzCitizenController@all');
            Route::get('/detail/{id}', 'Apz\ApzCitizenController@show');
        });

        Route::group(['prefix' => '/region', 'middleware' => 'role:region'], function () {
            Route::get('/', 'Apz\ApzRegionController@all');
            Route::get('/detail/{id}', 'Apz\ApzRegionController@show');
            Route::post('/status/{id}', 'Apz\ApzRegionController@decision');
        });

        Route::group(['prefix' => '/engineer', 'middleware' => 'role:engineer'], function () {
            Route::get('/', 'Apz\ApzEngineerController@all');
            Route::get('/detail/{id}', 'Apz\ApzEngineerController@show');
            Route::post('/create_commission/{id}', 'Apz\ApzEngineerController@createCommission');
            Route::post('/status/{id}', 'Apz\ApzEngineerController@decision');
        });

        Route::group(['prefix' => '/provider', 'middleware' => 'role:provider'], function () {
            Route::get('/{provider}', 'Apz\ApzProviderController@all');
            Route::get('/{provider}/{id}', 'Apz\ApzProviderController@show');
            Route::post('/{provider}/{id}/save', 'Apz\ApzProviderController@save');
            Route::get('/{provider}/{id}/update', 'Apz\ApzProviderController@update');
        });

        Route::group(['prefix' => '/head', 'middleware' => 'role:head'], function () {
            Route::get('/', 'Apz\ApzHeadController@all');
            Route::get('/detail/{id}', 'Apz\ApzHeadController@show');
            Route::post('status/{id}', 'Apz\ApzHeadController@decision');
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