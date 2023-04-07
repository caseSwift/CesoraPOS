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
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Auth\RegisterController;




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

Route::get("/main",[Main::class,"loadView"])->middleware('auth')->name('main');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

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


// this is going to be part of dealing with orders from javascript

Route::post('/orders/check-active', [OrderController::class,'checkActiveOrder']);
Route::post('/order-items',[OrderController::class,'storeOrderItem']);
Route::post('/orders', [OrderController::class,'store']);
Route::get("/cc1",[OrderController::class,'cc1']);

Route::get('/newOrder',[OrderController::class,'newOrder']);
Route::post('/orders/get-active-items',[OrderController::class,'getActiveItems']);

// check out

Route::post('/table/{id}/checkout',[OrderController::class,'checkout'])->name('table.checkout');

// Show all inventory items
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

// Show the form for creating a new inventory item
Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');

// Store a new inventory item in the database
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');

// Show the form for editing an existing inventory item
Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');

// Update an existing inventory item in the database
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');

// Delete an existing inventory item from the database
Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

// audits
Route::get('/audit-trail', [AuditController::class,'index'])->name('audit.index');

Route::get('/daily-profit', [OrderController::class, 'getDailyProfit'])->name('daily-profit');




