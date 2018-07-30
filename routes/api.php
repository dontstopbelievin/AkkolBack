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
Route::get('/search', 'HomeController@search');

Route::get('get_email/{email}/{token}', 'GetEmailController@getEmail');

Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['prefix' => '/newsPanel'], function () {
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

    Route::group(['prefix' => '/addPages', 'middleware' => 'role:admin'], function () {
        Route::get('/', 'StaticPagesController@all');
        Route::post('/insert', 'StaticPagesController@insert');
        Route::get('/show/{id}', 'StaticPagesController@show');
        Route::post('/update', 'StaticPagesController@update');
        Route::get('/delete/{id}', 'StaticPagesController@delete');
    });

    Route::group(['prefix' => '/menu', 'middleware' => 'role:admin'], function () {
        Route::get('/', 'MenuItemController@all');
        Route::get('/categories', 'MenuItemController@getCategories');
        Route::post('/category/insert', 'MenuItemController@insertCategories');
        Route::get('/category/delete/{id}', 'MenuItemController@deleteCategories');
        Route::get('/pages', 'MenuItemController@getPages');
        Route::get('/roles', 'MenuItemController@getRoles');
        Route::post('/insert', 'MenuItemController@insert');
        Route::get('/show/{id}', 'MenuItemController@show');
        Route::post('/update/{id}', 'MenuItemController@update');
        Route::get('/delete/{id}', 'MenuItemController@delete');
    });

    Route::group(['prefix' => '/questions'], function () {
        Route::post('/insert/{id}','QuestionsController@insert');
        Route::get('/getQuestions/{id}','QuestionsController@allUsers');
        Route::get('/delete/{id}','QuestionsController@delete');
    });

    Route::group(['prefix' => '/questions/admin', 'middleware' => 'role:admin'], function () {
        Route::post('/answer','QuestionsController@update');
        Route::get('/getQuestions','QuestionsController@all');
        Route::get('/delete/{id}','QuestionsController@delete');
    });

  Route::group(['prefix' => '/vacancies'], function () {
    Route::post('/insert','VacanciesController@insert');
    Route::post('/update/{id}','VacanciesController@update');
    Route::get('/delete/{id}','VacanciesController@delete');
    Route::get('/recovery/{id}','VacanciesController@recovery');
    Route::get('/disable/{id}','VacanciesController@disable');
    Route::get('/un-disable/{id}','VacanciesController@unDisable');
    Route::get('/allTrashed','VacanciesController@allTrashed');
    Route::get('/all/{status}','VacanciesController@all');
    Route::get('/show/{id}','VacanciesController@show');
  });


});



Route::post('/insertWithoutUser','QuestionsController@insertWithoutUser');
Route::get('/allQuestionsWithAnswer','QuestionsController@all');

Route::group(['prefix' => '/guest/vacancies'], function () {
  Route::get('/all','VacanciesController@allForGuests');
  Route::get('/show/{id}','VacanciesController@show');
});

Route::group(['prefix' => '/menu'], function () {
    Route::get('/', 'MenuItemController@all');
    Route::get('/categories', 'MenuItemController@getCategories')->name('getting-categories');
    Route::get('/roles', 'MenuItemController@getRoles');
    Route::get('/items/{name}', 'MenuItemController@getItems');
});

Route::group(['prefix' => '/getPage'],function (){
   Route::get('/show/{id}', 'StaticPagesController@show');
});

Route::group(['prefix' => '/news' ],function() {
    Route::get( '/lastFresh', 'NewsController@lastFresh');
    Route::get( '/all', 'NewsController@allNews');
    Route::get( '/article/{id}', 'NewsController@article');
    Route::get( '/dayNews/{day}', 'NewsController@dayNews');
});
