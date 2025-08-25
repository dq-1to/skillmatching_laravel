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

// カスタムパスワードリセットルート
Route::get('/password/reset', 'Auth\CustomPasswordResetController@showResetForm')->name('password.request');
Route::post('/password/generate-link', 'Auth\CustomPasswordResetController@generateResetLink')->name('password.generate.link');
Route::get('/password/reset/redirect', 'Auth\CustomPasswordResetController@redirectToReset')->name('password.reset.redirect');

// 標準の認証ルート（パスワードリセット以外）
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/verification-notification', 'Auth\VerificationController@resend')->name('verification.resend');

// 管理者用ルート
Route::prefix('admin')->middleware(['auth','admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

    // ユーザー管理・投稿管理
    Route::get('/userlist',  'Admin\UserListController@index')->name('userlist');
    Route::get('/postslist', 'Admin\PostListController@index')->name('postslist');
    
    // 投稿・ユーザーの停止/解除
    Route::put('/posts/{post}/toggle', 'Admin\PostListController@toggle')->name('posts.toggle');
    Route::put('/users/{user}/toggle', 'Admin\UserListController@toggle')->name('users.toggle');

    // 通報管理
    Route::get('/reports',            'Admin\ReportController@index')->name('reports.index');
    Route::get('/reports/{report}',   'Admin\ReportController@show')->name('reports.show');
    Route::put('/reports/{report}',   'Admin\ReportController@update')->name('reports.update');
    Route::delete('/reports/{report}','Admin\ReportController@destroy')->name('reports.destroy');
});
