<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
<<<<<<< HEAD
use App\Http\Controllers\ApiController;
=======
use App\Http\Controllers\SettingsController;
>>>>>>> 8c07b4c38459e4d764b8079056e9643531303664
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Cache::remember('users', 15, function () {
    //     return User::all();
    // });

    Route::middleware(['role:Admin|Writer'])->group(function () {
        Route::get('/todolist', [TodolistController::class,'index']);
    });
    Route::get('/todolist/lazyeager', [TodolistController::class,'lazyeager']);
    Route::get('/todolist/polyrel', [TodolistController::class,'polyrel']);
    Route::get('/todolist/polyreltask', [TodolistController::class,'polyreltask']);
    Route::get('/todolist/todolistScope', [TodolistController::class,'todolistScope']);
    Route::get('/todolist/localScope', [TodolistController::class,'localScope']);

    Route::middleware(['permission:delete todolist'])->group(function () {
        Route::get('/todolist/{todolist}', [TodolistController::class,'show']);
    });

    //User management module
    Route::get('user', [UserController::class,'index'])->name('user.index');
    Route::middleware(['role_or_permission: Writer|update todolist'])->group(function () {
        Route::get('user2', [UserController::class,'index2'])->name('user.index2');
    });
    Route::get('user/loadFromCache', [UserController::class,'loadFromCache'])->name('user.loadFromCache');
    Route::post('user/ajaxLoadUserTable', [UserController::class,'ajaxLoadUserTable'])->name('user.ajaxLoadUserTable');
    Route::post('user/storeRole', [UserController::class,'storeRole'])->name('user.storeRole');
    Route::post('user/storePermission', [UserController::class,'storePermission'])->name('user.storePermission');
    Route::post('user/getRolePermissions', [UserController::class,'getRolePermissions'])->name('user.getRolePermissions');
    Route::post('user/roleassignpermission', [UserController::class,'roleassignpermission'])->name('user.roleassignpermission');
    Route::post('user/userassignrole', [UserController::class,'userassignrole'])->name('user.userassignrole');
    Route::post('user/userassignpermission', [UserController::class,'userassignpermission'])->name('user.userassignpermission');
    Route::post('user/removeuserrolepermission', [UserController::class,'removeuserrolepermission'])->name('user.removeuserrolepermission');

    Route::get('task',[TaskController::class,'index'])->name('task.index');
    Route::get('task/collect',[TaskController::class,'collect'])->name('task.collect');
    Route::get('task/sendEmail',[TaskController::class,'sendEmail'])->name('task.sendEmail');
    Route::get('task/userattach',[TaskController::class,'userattach'])->name('task.userattach');

    Route::get('/settings', [SettingsController::class,'index']);
});
Route::get('/settings', [SettingsController::class,'index']);
Route::middleware('throttle:5,1')->get('task/ratelimiter',[TaskController::class,'ratelimiter'])->name('task.ratelimiter');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/redirect', function (Request $request) {
    $query = http_build_query([
        'client_id' => '9',
        'redirect_uri' => 'http://todolist2.test/callback',
        'client_secret' => 'mCnTzSZn8XNlA0AwNFeDUJqGeaiokvAEr2e6W5tl',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://todolist.test/oauth/authorize?'.$query);
});

Route::get('/callback', [ApiController::class,'callback']);
