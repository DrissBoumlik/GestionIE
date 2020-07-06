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


// Auth Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes();

Route::group([
    'middleware' => ['auth'],
], function () {


    //region Users / Roles / Permissions
    Route::get('/profile', 'UserController@profile');
    Route::resource('/users', 'UserController');
    Route::put('/changeStatus/{user}', 'UserController@changeStatus');
    Route::put('/updatePicture', 'UserController@updatePicture');
    Route::get('/getUsers', 'UserController@getUsers');
    Route::resource('/roles', 'RoleController');
    Route::get('/getRoles', 'RoleController@getRoles');
    //endregion

    Route::get('/', 'ToolController@home');
    Route::get('/dashboard', 'ToolController@home')->name('dashboard');

    Route::get('/import/tasks', 'ToolController@importView')->name('tasks.importView');
    Route::post('/import/tasks', 'ToolController@import')->name('tasks.import');

    Route::get('/unauthorized', 'ToolController@unauthorized');
});
