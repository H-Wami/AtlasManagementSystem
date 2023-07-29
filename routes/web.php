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

Route::group(['middleware' => ['guest']], function(){
    Route::namespace('Auth')->group(function(){
        // 新規ユーザー登録画面表示
        Route::get('/register', 'RegisterController@registerView')->name('registerView');
        // 新規ユーザー登録機能
        Route::post('/register/post', 'RegisterController@registerPost')->name('registerPost');
        // ログイン画面表示
        Route::get('/login', 'LoginController@loginView')->name('login'); //nameを'loginView'から'login'に修正。
        // ログイン情報送信機能
        Route::post('/login/post', 'LoginController@loginPost')->name('loginPost');
    });
});

Route::group(['middleware' => ['auth']], function(){ //'auth'に[]をつけて修正。
    Route::namespace('Authenticated')->group(function(){
        Route::namespace('Top')->group(function(){
            // ログアウト機能
            Route::get('/logout', 'TopsController@logout');
            // トップページ画面
            Route::get('/top', 'TopsController@show')->name('top.show');
        });
        Route::namespace('Calendar')->group(function(){
            Route::namespace('General')->group(function(){
                // スクール予約ページ画面表示
                Route::get('/calendar/{user_id}', 'CalendarsController@show')->name('calendar.general.show');
                Route::post('/reserve/calendar', 'CalendarsController@reserve')->name('reserveParts');
                Route::post('/delete/calendar', 'CalendarsController@delete')->name('deleteParts');
            });
            Route::namespace('Admin')->group(function(){
                // スクール予約確認画面表示
                Route::get('/calendar/{user_id}/admin', 'CalendarsController@show')->name('calendar.admin.show');
                Route::get('/calendar/{date}/{part}', 'CalendarsController@reserveDetail')->name('calendar.admin.detail');
                // スクール枠登録画面表示
                Route::get('/setting/{user_id}/admin', 'CalendarsController@reserveSettings')->name('calendar.admin.setting');
                Route::post('/setting/update/admin', 'CalendarsController@updateSettings')->name('calendar.admin.update');
            });
        });
        Route::namespace('BulletinBoard')->group(function(){
            // 投稿一覧画面表示
            Route::get('/bulletin_board/posts/{keyword?}', 'PostsController@show')->name('post.show');
            // 投稿画面表示
            Route::get('/bulletin_board/input', 'PostsController@postInput')->name('post.input');
            // いいねした投稿表示
            Route::get('/bulletin_board/like', 'PostsController@likeBulletinBoard')->name('like.bulletin.board');
            // 自分の投稿表示
            Route::get('/bulletin_board/my_post', 'PostsController@myBulletinBoard')->name('my.bulletin.board');
            // 新規投稿作成機能
            Route::post('/bulletin_board/create', 'PostsController@postCreate')->name('post.create');
            // メインカテゴリー作成機能
            Route::post('/create/main_category', 'PostsController@mainCategoryCreate')->name('main.category.create');
            Route::post('/create/sub_category', 'PostsController@subCategoryCreate')->name('sub.category.create');
            // 投稿詳細画面表示
            Route::get('/bulletin_board/post/{id}', 'PostsController@postDetail')->name('post.detail');
            // 投稿編集機能
            Route::post('/bulletin_board/edit', 'PostsController@postEdit')->name('post.edit');
            // 投稿削除機能
            Route::get('/bulletin_board/delete/{id}', 'PostsController@postDelete')->name('post.delete');
            Route::post('/comment/create', 'PostsController@commentCreate')->name('comment.create');
            // いいね登録機能
            Route::post('/like/post/{id}', 'PostsController@postLike')->name('post.like');
            // いいね削除機能
            Route::post('/unlike/post/{id}', 'PostsController@postUnLike')->name('post.unlike');
        });
        Route::namespace('Users')->group(function(){
            // ユーザー検索画面表示
            Route::get('/show/users', 'UsersController@showUsers')->name('user.show');
            Route::get('/user/profile/{id}', 'UsersController@userProfile')->name('user.profile');
            Route::post('/user/profile/edit', 'UsersController@userEdit')->name('user.edit');
        });
    });
});
