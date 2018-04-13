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
Route::get('get_token_xml', 'Auth\LoginController@getTokenXml');
Route::post('login_with_cert', 'Auth\LoginController@loginWithCert');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@create'])->middleware('cors');
Route::get('/user_info', 'Auth\LoginController@userInfo');

Route::group(['prefix' => 'system_files'], function () {
    Route::get('/category/{name}', 'FileController@getFromSystemCategory');
    Route::get('/download/{type}/{id}', 'FileController@downloadSystemFile');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => '/apz'], function () {
        Route::group(['prefix' => '/citizen', 'middleware' => 'role:citizen'], function () {
            Route::get('/', 'Apz\ApzCitizenController@all');
            Route::get('/detail/{id}', 'Apz\ApzCitizenController@show');
            Route::post('/create', 'Apz\ApzCitizenController@create');
            Route::post('/upload/{id}', 'Apz\ApzCitizenController@upload');
        });

        Route::group(['prefix' => '/region', 'middleware' => 'role:region'], function () {
            Route::get('/', 'Apz\ApzRegionController@all');
            Route::get('/detail/{id}', 'Apz\ApzRegionController@show');
            Route::post('/status/{id}', 'Apz\ApzRegionController@decision');
            Route::get('/get_xml/{id}', 'Apz\ApzRegionController@generateXml');
            Route::post('/save_xml/{id}', 'Apz\ApzRegionController@saveXml');
        });

        Route::group(['prefix' => '/engineer', 'middleware' => 'role:engineer'], function () {
            Route::get('/', 'Apz\ApzEngineerController@all');
            Route::get('/detail/{id}', 'Apz\ApzEngineerController@show');
            Route::get('/get_commission/{id}', 'Apz\ApzEngineerController@getCommission');
            Route::post('/create_commission/{id}', 'Apz\ApzEngineerController@createCommission');
            Route::post('/status/{id}', 'Apz\ApzEngineerController@decision');
        });

        Route::group(['prefix' => '/provider', 'middleware' => 'role:provider'], function () {
            Route::get('/get_xml/{provider}/{id}', 'Apz\ApzProviderController@generateXml');
            Route::post('/save_xml/{provider}/{id}', 'Apz\ApzProviderController@saveXml');
            Route::get('/{provider}', 'Apz\ApzProviderController@all');
            Route::get('/{provider}/{id}', 'Apz\ApzProviderController@show');
            Route::post('/{provider}/{id}/save', 'Apz\ApzProviderController@save');
            Route::get('/{provider}/{id}/update', 'Apz\ApzProviderController@update');
            Route::post('/{provider}/{id}/response', 'Apz\ApzProviderController@headDecision');
        });

        Route::group(['prefix' => '/apz_department', 'middleware' => 'role:apzdepartment'], function () {
            Route::get('/get_xml/{id}', 'Apz\ApzDepartmentController@generateXml');
            Route::post('/save_xml/{id}', 'Apz\ApzDepartmentController@saveXml');
            Route::get('/', 'Apz\ApzDepartmentController@all');
            Route::get('/detail/{id}', 'Apz\ApzDepartmentController@show');
            Route::post('/status/{id}', 'Apz\ApzDepartmentController@decision');
        });

        Route::group(['prefix' => '/head', 'middleware' => 'role:head'], function () {
            Route::get('/get_xml/{id}', 'Apz\ApzHeadController@generateXml');
            Route::post('/save_xml/{id}', 'Apz\ApzHeadController@saveXml');
            Route::get('/', 'Apz\ApzHeadController@all');
            Route::get('/detail/{id}', 'Apz\ApzHeadController@show');
            Route::post('save/{id}', 'Apz\ApzHeadController@save');
            Route::post('status/{id}', 'Apz\ApzHeadController@decision');
        });
    });

    Route::group(['prefix' => '/print'], function () {
        Route::get('/apz/{id}', 'ApzPrintController@printApz');
        Route::get('/tc/{tc}/{id}', 'ApzPrintController@printTc');
    });

    Route::group(['prefix' => '/file'], function () {
        Route::get('/', 'FileController@index');
        Route::get('all', 'FileController@all');
        Route::get('images', 'FileController@images');
        Route::get('categoriesList', 'FileController@categoriesList');
        Route::get('download/{id}', 'FileController@download');
        Route::post('upload', 'FileController@upload');
        Route::post('delete/{id}', 'FileController@delete');
    });

    Route::group(['prefix' => '/photoreport'], function () {
        Route::get('/', 'PhotoReportController@index');
        Route::post('/create', 'PhotoReportController@create');
        Route::post('/response', 'PhotoReportController@response');
        Route::get('/personal', 'PhotoReportController@personal');
    });

    Route::group(['prefix' => '/newsPanel', 'middleware' => 'role:admin'], function () {
        Route::get('/', 'NewsController@all');
        Route::post('/insert', 'NewsController@insert');
        Route::get('/edit/{id}', 'NewsController@edit');
        Route::post('/update', 'NewsController@update');
        Route::get('/delete/{id}', 'NewsController@delete');
    });


    Route::group(['prefix' => '/personalData'], function () {
        Route::post('/update/{id}', 'PersonalDataController@update');
        Route::get('/edit/{id}', 'PersonalDataController@edit');
        Route::post('/editPassword/{id}', 'PersonalDataController@editPassword');
        Route::post('/updatePassword/{id}', 'PersonalDataController@updatePassword');
    });
});