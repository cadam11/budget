<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => 'api'], function () {
    // Route::group(['prefix' => 'api'], function(){

    //     Route::post('import', 'ImportController@apiImport');

    // });
});



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function(){

        // this should be removed once api key auth is set up
        Route::group(['prefix' => 'api'], function(){
            Route::post('import', 'ImportController@apiImport');
        });        

        Route::get('/',             ['as' => 'home',        'uses' => 'HomeController@index']);
        Route::get('categories',    ['as' => 'categories',  'uses' => 'CategoryController@index']);

        Route::group(['as' => 'budgets::', 'prefix' => 'budgets'], function() {

            Route::get('/',             ['as' => 'index',   'uses' => 'BudgetController@index']);
            Route::get('/create',       ['as' => 'create',  'uses' => 'BudgetController@create']);
            Route::get('/copy',         ['as' => 'copy',    'uses' => 'BudgetController@copy']);
            Route::post('/',            ['as' => 'save',    'uses' => 'BudgetController@store']);
            Route::post('/{id}',        ['as' => 'update',  'uses' => 'BudgetController@update']);
            Route::get('/{id}/delete',  ['as' => 'delete',  'uses' => 'BudgetController@destroy']);

        });

        Route::group(['as' => 'transactions::', 'prefix' => 'transactions'], function() {

            Route::get('/',           ['as' => 'index',  'uses' => 'TransactionController@index']);
            Route::get('/create',     ['as' => 'create', 'uses' => 'TransactionController@create']);
            Route::post('/',          ['as' => 'save',   'uses' => 'TransactionController@store']);
            Route::post('{id}',       ['as' => 'update', 'uses' => 'TransactionController@update']);
            Route::get('{id}/delete', ['as' => 'delete', 'uses' => 'TransactionController@destroy']);

            Route::get( 'import',       ['as'=>'import',        'uses' => 'ImportController@index']);
            Route::post('import',       ['as'=>'saveImport',    'uses' => 'ImportController@store']);
            Route::get( 'import/parse', ['as'=>'parseImport',   'uses' => 'ImportController@parse']);
        });


        Route::group(['as' => 'admin::', 'prefix' => 'admin'], function(){
            Route::get( 'todo',      ['as' => 'todo',        'uses' => 'AdminController@todo']);
            Route::get( 'info',      ['as' => 'info',        'uses' => 'AdminController@info']);
            Route::get( 'settings',  ['as' => 'settings',    'uses' => 'AdminController@settings']);
            Route::post('settings',  ['as' => 'saveSettings','uses' => 'AdminController@storeSettings']);
            
            Route::group(['as' => 'rules::', 'prefix' => 'rules'], function() {

                Route::get( '/',            ['as' => 'index',  'uses' => 'RulesController@index']);
                Route::post('/',            ['as' => 'save',   'uses' => 'RulesController@store']);
                Route::get( 'create',       ['as' => 'create', 'uses' => 'RulesController@create']);
                Route::get( '{id}/delete',  ['as' => 'delete', 'uses' => 'RulesController@destroy']);
                Route::post('{id}',         ['as' => 'update', 'uses' => 'RulesController@update']);
            });


        });
    });
});
