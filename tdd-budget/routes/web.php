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

Route::get('/transactions/create', TransactionsController::class . "@create");
Route::get('/transactions/{category?}', TransactionsController::class . "@index")
    ->name('transactions.index');
Route::get('/transactions/{transaction}', TransactionsController::class . "@edit");
Route::post('/transactions', TransactionsController::class . "@store");
Route::put('/transactions/{transaction}', TransactionsController::class . "@update");
Route::delete('/transactions/{transaction}', TransactionsController::class . "@destroy");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
