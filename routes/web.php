<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AssignRoleController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/main",[Main::class,"loadView"])->middleware('auth');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// This one may be problem
Route::get('/table/{id}/orders', [TableController::class, 'showOrders'])->middleware('auth');

Route::post('/table/{id}/orders', [OrderController::class, 'store'])->name('table.orders.store');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/table','table');

Route::get('/table/{id}', [TableController::class, 'showTable'])->name('table.show');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');

Route::post('/tables/{table}/orders', [OrderController::class, 'placeOrder'])->name('place.order');

Route::get('/assign-role-to-user', [AssignRoleController::class, 'assignRoleToUser']);

Route::get('/administrator', [AdminController::class, 'index'])->middleware(['auth', 'role:administrator']);

Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/administrator', [AdminController::class, 'loadView']);
});

Route::get('/articles/{type}', 'ArticleController@index')->name('articles.index');

