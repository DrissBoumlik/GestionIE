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
    Route::get('/b2bSfr/create','TicketsController@create')->name('b2bSfr.create');
    Route::post('/b2bSfr/store','TicketsController@store')->name('b2bSfr.store');
    Route::get('/b2bSfr/ongoing','TicketsController@ongoing')->name('b2bSfr.ongoing');
    Route::get('/b2bSfr/valid','TicketsController@valid')->name('b2bSfr.valid');
    Route::get('/b2bSfr/closed','TicketsController@closed')->name('b2bSfr.closed');
    Route::post('/b2bSfr/tickets/getTickets/{status}','TicketsController@getTickets');
    Route::put('/b2bSfr/tickets/updateTicket/{id}','TicketsController@updateTicket');
    Route::get('b2bSfr/tickets/getTicketHistory/{id}','TicketsController@getTicketHistory');

    Route::get('/', 'HomeController@home');
    Route::get('/dashboard', 'HomeController@home')->name('dashboard');

    Route::get('/tasks/data/{type?}', 'TaskController@allData')->name('tasks.dataView');
    Route::post('/api/tasks/data/{type}', 'TaskController@getTasks')->name('tasks.data');

    Route::get('/tasks/filter/{status}/{type}', 'TaskController@viewTasksByStatus')->name('tasks.dataView.filter');
    Route::post('/api/tasks/filter/{status}/{type}', 'TaskController@getTasksbyStatus')->name('tasks.data.filter');

    Route::get('/api/tasks/history/{type}', 'TaskLogController@getTasksLog');
    Route::get('/api/tasks/history/{status}/{type}/{task?}', 'TaskLogController@getTasksLogByStatus');

    Route::post('/api/tasks/{type}', 'TaskController@assignTask');
    Route::put('/api/tasks/{type}', 'TaskController@editTask');
    Route::delete('/api/tasks/{type}', 'TaskController@dropTask');

    //region Import / Export
//    Route::get('/import/tasks', 'ImportController@importView')->name('tasks.importView');
    Route::view('/import/tasks', 'tasks.import')->name('tasks.importView');
    Route::post('/import/tasks', 'ImportController@import')->name('tasks.import');

    Route::get('/import/data/count', 'ImportController@getInsertedData');
    Route::get('/import/status/edit/{flag}', 'ImportController@editImportingStatus');
    //endregion

    Route::get('/unauthorized', 'ExceptionController@unauthorized');
});
