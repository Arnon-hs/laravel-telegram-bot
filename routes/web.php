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

define('DEFAULT_URL', "https://www.edimdoma.ru/retsepty");
set_time_limit(360);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::match(['get', 'post'], 'register', function(){
	Auth::logout();
	return redirect('/');
})->name('register');

Route::middleware(['auth'])->prefix('admin')->namespace('Backend')->name('admin.')->group(function(){
	Route::get('/', 'DashBoardController@index')->name('index');
	Route::get('/setting', 'SettingController@index')->name('setting.index');
	Route::post('/setting/store', 'SettingController@store')->name('setting.store');
	Route::post('/setting/setwebhook', 'SettingController@setwebhook')->name('setting.setwebhook');
	Route::post('/setting/getwebhookinfo', 'SettingController@getwebhookinfo')->name('setting.getwebhookinfo');
});

Route::post(Telegram::getAccessToken(), function(){
	app('App\Http\Controllers\Backend\TelegramController')->webhook();
});

Route::get('/parser', 'ParseController@getLinks')->name('parse');

Route::get('/home', 'HomeController@index')->name('home');
