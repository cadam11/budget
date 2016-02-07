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

    Route::get('/settings/todo', 'HomeController@todo');

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/create', 'TransactionController@create');
    Route::post('/transactions', 'TransactionController@store');
    Route::post('/transactions/{id}', 'TransactionController@update');
    Route::get('/transactions/{id}/delete', 'TransactionController@destroy');


    Route::get('/categories', 'CategoryController@index');

    Route::get('/budgets', 'BudgetController@index');
    Route::get('/budgets/create', 'BudgetController@create');
    Route::get('/budgets/copy', 'BudgetController@copy');
    Route::post('/budgets', 'BudgetController@store');
    Route::post('/budgets/{id}', 'BudgetController@update');
    Route::get('/budgets/{id}/delete', 'BudgetController@destroy');

    Route::get('/transactions/import', 'ImportController@index');
    Route::post('/transactions/import', 'ImportController@store');
    Route::get('/transactions/import/parse', 'ImportController@parse');

    Route::post('/api/import', 'ImportController@apiImport');

    Route::get('/settings/rules', 'RulesController@index');
    Route::get('/settings/rules/create', 'RulesController@create');
    Route::get('/settings/rules/{id}/delete', 'RulesController@destroy');
    Route::post('/settings/rules', 'RulesController@store');
    Route::post('/settings/rules/{id}', 'RulesController@update');
});
