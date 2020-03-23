<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::prefix('profile')->name('profile.')->group(function () {
	Route::resource('balance', 'BalanceController')->except(['create', 'show']);
	Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
});

