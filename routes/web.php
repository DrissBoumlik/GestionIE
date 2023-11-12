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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskLogController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserController;

Auth::routes();

Route::group([
    'middleware' => ['auth'],
], function () {

    Route::get('/dates', [ReportingController::class, 'getDates']);

    //region Users / Roles / Permissions
    Route::get('/profile', [UserController::class, 'profile']);
    Route::resource('/users', UserController::class);
    Route::put('/changeStatus/{user}', [UserController::class, 'changeStatus']);
    Route::put('/updatePicture', [UserController::class, 'updatePicture']);
    Route::get('/getUsers', [UserController::class, 'getUsers']);
    Route::resource('/roles', RoleController::class);
    Route::get('/getRoles', [RoleController::class, 'getRoles']);
    //endregion

    //region B2b
    Route::get('b2bSfr/tickets/{status}',[TicketsController::class, 'index'])->name('b2bSfr.tickets');
    Route::get('b2bSfr/getTickets/byStatus/{status}', [TicketsController::class, 'show']);
    Route::get('b2bSfr/create', [TicketsController::class, 'create'])->name('b2bSfr.create');
    Route::post('/b2bSfr/store', [TicketsController::class, 'store'])->name('b2bSfr.store');
    Route::get('b2bSfr/tickets/edit/{id}', [TicketsController::class, 'edit'])->name('b2bSfr.tickets.edit');
    Route::put('/b2bSfr/tickets/updateTicket/{id}', [TicketsController::class, 'updateTicket'])->name('b2bSfr.tickets.update');
    Route::get('b2bSfr/tickets/getTicketHistory/{id}', [TicketsController::class, 'getTicketHistory'])->name('b2bSfr.tickets.history');
    Route::get('b2bSfr/tickets/showTicketHistoryPage/{id}', [TicketsController::class, 'showTicketHistoryPage'])->name('b2bSfr.tickets.showTicketHistoryPage');

    Route::get('reporting', [ReportingController::class, 'index'])->name('reporting');
    Route::post('reporting/getInstance', [ReportingController::class, 'getInstance']);
    Route::post('/reporting/getEnCours', [ReportingController::class, 'getEnCours']);
    Route::post('/reporting/getGlobalData', [ReportingController::class, 'getGlobalData']);
    Route::get('/reporting/exportData/{entity}', [ReportingController::class, 'exportData'])->name('exportData');
    //end region

    Route::get('/', [HomeController::class, 'home']);
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

    Route::get('/tasks/data/{type?}', [TaskController::class, 'allData'])->name('tasks.dataView');
    Route::post('/api/tasks/data/{type}', [TaskController::class, 'getTasks'])->name('tasks.data');
    Route::get('/tasks/exportData/{type}', [TaskController::class, 'exportData'])->name('tasks.dataExport');


    Route::get('/tasks/filter/{status}/{type}',  [TaskController::class, 'viewTasksByStatus'])->name('tasks.dataView.filter');
    Route::post('/api/tasks/filter/{status}/{type}',  [TaskController::class, 'getTasksbyStatus'])->name('tasks.data.filter');
    Route::post('/api/tasks/setVerified/{type}', [TaskController::class, 'updateSetOfTasks']);

    Route::get('/tasks/traite/{type}', [TaskController::class, 'viewTasksByStatusFinal'])->name('tasks.dataView.statutF');
    Route::post('/api/tasks/traite/{type}', [TaskController::class, 'getTasksbyStatusFinal'])->name('tasks.data.statutF');

    Route::get('/api/tasks/history/{type}', [TaskLogController::class, 'getTasksLog']);
    Route::get('/api/tasks/history/{status}/{type}/{task?}', [TaskLogController::class, 'getTasksLogByStatus']);

    Route::post('/api/tasks/{type}', [TaskController::class, 'assignTask']);
    Route::put('/api/tasks/{type}', [TaskController::class, 'editTask']);
    Route::delete('/api/tasks/{type}', [TaskController::class, 'dropTask']);

    //region Import / Export
//    Route::get('/import/tasks', 'ImportController::class, 'importView')->name('tasks.importView');
    Route::view('/import/tasks', 'tasks.import')->name('tasks.importView');
    Route::post('/import/tasks',  [ImportController::class, 'import'])->name('tasks.import');

    Route::get('/import/data/count', [ImportController::class, 'getInsertedData']);
    Route::get('/import/status/edit/{flag}', [ImportController::class, 'editImportingStatus']);
    //endregion

    Route::get('/user/filter', [FilterController::class, 'getUserFilter']);
    Route::post('/user/filter', [FilterController::class, 'saveUserFilter']);


    Route::get('/unauthorized', [ExceptionController::class, 'unauthorized']);
});
