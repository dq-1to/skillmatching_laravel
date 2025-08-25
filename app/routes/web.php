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

// ブックマーク関連
Route::middleware('auth')->group(function () {
    // 追加: 非同期APIっぽくJSONレスポンスを返す
    Route::post('/bookmarks/{post}', 'BookmarkController@store')->name('bookmarks.store');
    Route::delete('/bookmarks/{post}', 'BookmarkController@destroy')->name('bookmarks.destroy');
});

// ユーザー側（作成・閲覧は要ログイン）
Route::middleware('auth')->group(function () {
    Route::get('/reports/create', 'ReportController@create')->name('reports.create'); // ?post=ID
    Route::post('/reports', 'ReportController@store')->name('reports.store');
    Route::get('/reports/{report}', 'ReportController@show')->name('reports.show'); // 自分が出した通報のみ参照
});

Auth::routes();

// 管理者側（すべての管理者機能を統合）
Route::middleware(['auth', 'admin'])->group(function () {
    // ダッシュボード・ユーザー管理・投稿管理
    Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/admin/userlist', 'AdminController@userlist')->name('admin.userlist');
    Route::get('/admin/postslist', 'AdminController@postslist')->name('admin.postslist');
    
    // 通報管理
    Route::get('/admin/reports', 'Admin\\ReportController@index')->name('admin.reports.index');
    Route::get('/admin/reports/{report}', 'Admin\\ReportController@show')->name('admin.reports.show');
    Route::put('/admin/reports/{report}', 'Admin\\ReportController@update')->name('admin.reports.update');   // ステータス変更
    Route::delete('/admin/reports/{report}', 'Admin\\ReportController@destroy')->name('admin.reports.destroy'); // del_flag=1
});

