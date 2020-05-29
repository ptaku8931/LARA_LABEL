<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// 新規登録 api
Route::post('/register', 'Auth\RegisterController@register')->name('register');
// ログイン api
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト api
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// ログインユーザー確認
Route::get('/user', function() { 
    return Auth::user();
})->name('user');
// ラベルフォルダ api
Route::resource('label_folder', 'LabelFolderController');
// ラベル api
Route::resource('label', 'LabelController');
// アカウント削除
Route::delete('/user/softdelete', 'UserController@softdelete');

Route::put('/Fdragdrop', 'LabelFolderController@dragdrop');
Route::put('/Ldragdrop', 'LabelController@dragdrop');

Route::get('/login/{provider}', 'Auth\OAuthController@socialOAuth');
Route::get('/login/{provider}/callback', 'Auth\OAuthController@handleProviderCallback');
