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

// Route::get('/', function () {
//     Route::auth();

//     Route::get('/', 'HomeController@index');
// });

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

    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    Route::get('/settings', 'HomeController@settings');

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/create', 'TransactionController@create');
    Route::post('/transactions', 'TransactionController@store');
    Route::post('/transactions/{id}', 'TransactionController@update');


    Route::get('/categories', 'CategoryController@index');

    Route::get('/budgets/create', 'BudgetController@create');
    Route::get('/budgets', 'BudgetController@index');
    Route::post('/budgets', 'BudgetController@store');
    Route::post('/budgets/{id}', 'BudgetController@update');

    Route::get('/import', 'ImportController@index');
    Route::post('/import', 'ImportController@store');
    Route::get('/import/parse', 'ImportController@parse');
});
