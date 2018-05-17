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

Auth::routes();

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

Route::get('get_email/{email}/{token}', 'GetEmailController@getEmail');

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => '/apz'], function () {
        Route::group(['prefix' => '/citizen', 'middleware' => 'role:citizen'], function () {
            Route::get('/', 'Apz\ApzCitizenController@all');
            Route::get('/detail/{id}', 'Apz\ApzCitizenController@show');
            Route::post('/create', 'Apz\ApzCitizenController@create')->middleware('holiday');
            Route::post('/upload/{id}', 'Apz\ApzCitizenController@upload')->middleware('holiday');
            Route::post('/company_search', 'Apz\ApzCitizenController@companySearch');
        });

        Route::group(['prefix' => '/region', 'middleware' => 'role:region'], function () {
            Route::get('/', 'Apz\ApzRegionController@all');
            Route::get('/detail/{id}', 'Apz\ApzRegionController@show');
            Route::post('/status/{id}', 'Apz\ApzRegionController@decision')->middleware('holiday');
            Route::get('/get_xml/{id}', 'Apz\ApzRegionController@generateXml');
            Route::post('/save_xml/{id}', 'Apz\ApzRegionController@saveXml')->middleware('holiday');
        });

        Route::group(['prefix' => '/engineer', 'middleware' => 'role:engineer'], function () {
            Route::get('/', 'Apz\ApzEngineerController@all');
            Route::get('/detail/{id}', 'Apz\ApzEngineerController@show');
            Route::get('/get_commission/{id}', 'Apz\ApzEngineerController@getCommission');
            Route::post('/create_commission/{id}', 'Apz\ApzEngineerController@createCommission')->middleware('holiday');
            Route::post('/status/{id}', 'Apz\ApzEngineerController@decision')->middleware('holiday');
        });

        Route::group(['prefix' => '/provider', 'middleware' => 'role:provider'], function () {
            Route::get('/get_xml/{provider}/{id}', 'Apz\ApzProviderController@generateXml');
            Route::post('/save_xml/{provider}/{id}', 'Apz\ApzProviderController@saveXml')->middleware('holiday');
            Route::get('/{provider}', 'Apz\ApzProviderController@all');
            Route::get('/{provider}/{id}', 'Apz\ApzProviderController@show');
            Route::post('/{provider}/{id}/save', 'Apz\ApzProviderController@save');
            Route::get('/{provider}/{id}/update', 'Apz\ApzProviderController@update')->middleware('holiday');
            Route::post('/{provider}/{id}/response', 'Apz\ApzProviderController@headDecision')->middleware('holiday');
        });

        Route::group(['prefix' => '/apz_department', 'middleware' => 'role:apzdepartment'], function () {
            Route::get('/get_xml/{id}', 'Apz\ApzDepartmentController@generateXml');
            Route::post('/save_xml/{id}', 'Apz\ApzDepartmentController@saveXml')->middleware('holiday');
            Route::get('/', 'Apz\ApzDepartmentController@all');
            Route::get('/detail/{id}', 'Apz\ApzDepartmentController@show');
            Route::post('/status/{id}', 'Apz\ApzDepartmentController@decision')->middleware('holiday');
        });

        Route::group(['prefix' => '/head', 'middleware' => 'role:head'], function () {
            Route::get('/get_xml/{id}', 'Apz\ApzHeadController@generateXml');
            Route::post('/save_xml/{id}', 'Apz\ApzHeadController@saveXml')->middleware('holiday');
            Route::get('/', 'Apz\ApzHeadController@all');
            Route::get('/detail/{id}', 'Apz\ApzHeadController@show');
            Route::post('save/{id}', 'Apz\ApzHeadController@save');
            Route::post('status/{id}', 'Apz\ApzHeadController@decision')->middleware('holiday');
        });

        Route::group(['prefix' => '/answer_template', 'middleware' => 'role:region'], function () {
            Route::get('/', 'Apz\ApzAnswerTemplateController@all');
            Route::post('/create', 'Apz\ApzAnswerTemplateController@create');
            Route::get('/detail/{id}', 'Apz\ApzAnswerTemplateController@show');
            Route::post('/update/{id}', 'Apz\ApzAnswerTemplateController@update');
            Route::post('/delete/{id}', 'Apz\ApzAnswerTemplateController@delete');
        });
    });

    Route::group(['prefix' => '/print'], function () {
        Route::get('/apz/{id}', 'ApzPrintController@printApz');
        Route::get('/tc/{tc}/{id}', 'ApzPrintController@printTc');
        Route::get('/region/{id}', 'ApzPrintController@printRegionAnswer');
    });

    Route::group(['prefix' => '/file'], function () {
        Route::get('/', 'FileController@index');
        Route::get('all', 'FileController@all');
        Route::get('images', 'FileController@images');
        Route::get('category/{id}', 'FileController@getFromCategory');
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

    Route::group(['prefix' => '/userTable', 'middleware' => 'role:admin'], function () {
        Route::get('/getUsers', 'UserTableController@allUsers');
        Route::get('/getRoles', 'UserTableController@getRoles');
        Route::get('/getUserRoles', 'UserTableController@getUserRoles');
        Route::get('/deleteUser/{id}', 'UserTableController@deleteUsers');
        Route::post('/addRoleToUser', 'UserTableController@addRoleToUser');
    });


    Route::group(['prefix' => '/personalData'], function () {
        Route::post('/update/{id}', 'PersonalDataController@update');
        Route::get('/edit/{id}', 'PersonalDataController@edit');
        Route::post('/editPassword/{id}', 'PersonalDataController@editPassword');
        Route::post('/updatePassword/{id}', 'PersonalDataController@updatePassword');
    });

    Route::group(['prefix' => '/sketch'], function () {
        Route::group(['prefix' => '/citizen', 'middleware' => 'role:citizen'], function () {
            Route::get('/', 'Sketch\SketchCitizenController@all');
            Route::get('/detail/{id}', 'Sketch\SketchCitizenController@show');
            Route::post('/create', 'Sketch\SketchCitizenController@create')->middleware('holiday');
        });
    });

    Route::group(['prefix' => '/addPages', 'middleware' => 'role:admin'], function () {
        Route::get('/', 'StaticPagesController@all');
        Route::post('/insert', 'StaticPagesController@insert');
        Route::get('/show/{id}', 'StaticPagesController@show');
        Route::post('/update', 'StaticPagesController@update');
        Route::get('/delete/{id}', 'StaticPagesController@delete');
    });

});

Route::group(['prefix' => '/news' ],function() {
    Route::get( '/lastFresh', 'NewsController@lastFresh');
    Route::get( '/all', 'NewsController@allNews');
    Route::get( '/article/{id}', 'NewsController@article');
    Route::get( '/dayNews/{day}', 'NewsController@dayNews');
});