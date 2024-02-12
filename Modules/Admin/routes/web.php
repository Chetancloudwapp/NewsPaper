<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\app\Http\Controllers\AdminController;

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



Route::prefix('admin')->group(function(){
    Route::match(['get','post'], '/login', 'AdminController@login');

    Route::group(['middleware' => ['admin_auth']], function(){
        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('/logout', 'AdminController@logout');
        Route::match(['get','post'], '/change_password', 'AdminController@ChangePassword');
        Route::match(['get','post'], '/check_current_password', 'AdminController@CheckCurrentPassword');
        Route::match(['get','post'], '/dashboard', 'DashboardController@index');

        // privay-policy
        Route::match(['get','post'], '/privacy-policy', 'PagesController@index');
        Route::match(['get','post'], '/privacy-policy/edit/{id}', 'PagesController@editPrivacyPolicy');

        // terms-n-conditions
        Route::match(['get','post'], '/terms-and-conditions', 'PagesController@tncIndex');
        Route::match(['get','post'], '/terms-and-conditions/edit/{id}', 'PagesController@editTnc');

        // categories
        Route::match(['get','post'], '/category', 'CategoryController@index');
        Route::match(['get','post'], '/category/add', 'CategoryController@addCategory');
        Route::match(['get','post'], '/category/edit/{id}', 'CategoryController@editCategory');
        Route::match(['get','post'], '/category/delete/{id}', 'CategoryController@destroy');

        // tags
        Route::match(['get','post'], '/tags', 'TagController@index');
        Route::match(['get','post'], '/tags/add', 'TagController@addTags');
        Route::match(['get','post'], '/tags/edit/{id}', 'TagController@editTags');
        Route::match(['get','post'], '/tags/delete/{id}', 'TagController@destroy');

        // users
        Route::match(['get','post'], '/users', 'UserController@index');
        Route::match(['get','post'], '/users/delete/{id}', 'UserController@destroy');
        Route::match(['get','post'], '/users/edit/{id}', 'UserController@editUser');

        // news
        Route::match(['get','post'], '/news', 'NewsController@index');
        Route::match(['get','post'], '/news/add', 'NewsController@addNews');
        Route::match(['get','post'], '/news/edit/{id}', 'NewsController@editNews');
        Route::match(['get','post'], '/news/delete/{id}', 'NewsController@destroy');
        Route::match(['get','post'], '/news/deleteImage/{id}', 'NewsController@deletegalleryImages');
        Route::match(['get','post'], '/news/view/{id}', 'NewsController@viewNews');
    });
    
});



