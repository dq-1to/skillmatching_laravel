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

// メインページ
Route::get('/', 'PostController@index')->name('home');
Route::get('/posts', 'PostController@index')->name('posts.index');

// 認証が必要な投稿関連
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', 'PostController@create')->name('posts.create');
    Route::post('/posts', 'PostController@store')->name('posts.store');
    Route::get('/posts/{post}/edit', 'PostController@edit')->name('posts.edit');
    Route::put('/posts/{post}', 'PostController@update')->name('posts.update');
    Route::delete('/posts/{post}', 'PostController@destroy')->name('posts.destroy');
});

Route::get('/posts/{post}', 'PostController@show')->name('posts.show'); 

// 依頼関連
Route::middleware('auth')->group(function () {
    Route::resource('requests', 'RequestController')
        ->parameters(['requests' => 'reqItem']); // ← {request} を {reqItem} に変更
});

// マイページ
Route::middleware('auth')->group(function () {
    Route::get('/mypage', 'MyPageController@show')->name('mypage.show');

    // プロフィール編集／退会
    Route::get('/mypage/profile', 'ProfileController@edit')->name('profile.edit');
    Route::put('/mypage/profile', 'ProfileController@update')->name('profile.update');
    Route::delete('/mypage/profile', 'ProfileController@destroy')->name('profile.destroy');
});

Auth::routes();

// 管理者
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/userlist', 'AdminController@userlist')->name('admin.userlist');
    Route::get('/postslist', 'AdminController@postslist')->name('admin.postslist');
});

