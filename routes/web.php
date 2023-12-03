<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ServiceCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('front_end.home');
});
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'DONE'; //Return anything
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']], function(){
    Route::group(['prefix'=>'business'], function(){
        Route::get('/', [BusinessController::class, 'index'])->name('business');
        Route::get('/create', [BusinessController::class, 'create'])->name('business.create');
        Route::get('/edit/{id}', [BusinessController::class, 'edit'])->name('business.edit');
        Route::post('/store', [BusinessController::class, 'store'])->name('business.store');
        Route::post('/update/{id}', [BusinessController::class, 'update'])->name('business.update');
        Route::get('/delete/{id}', [BusinessController::class, 'delete'])->name('business.delete');
    });

    Route::group(['prefix'=>'user'], function(){
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::group(['prefix'=>'roles'], function(){
        Route::get('/', [RolesController::class, 'index'])->name('roles');
        Route::get('/create', [RolesController::class, 'create'])->name('role.create');
        Route::post('/store', [RolesController::class, 'store'])->name('role.store');
        Route::get('/edit/{role}', [RolesController::class, 'edit'])->name('role.edit');
        Route::put('/update/{role}', [RolesController::class, 'update'])->name('role.update');
        Route::get('/delete{role}', [RolesController::class, 'delete'])->name('role.delete');
        Route::get('assign-permission/{role}', [RolesController::class, 'assignPermission'])->name('role.permission');
        Route::post('permission-store/{role}', [RolesController::class, 'permissionStore'])->name('role.permission.store');
    });

    Route::group(['prefix'=>'customer'], function(){
        Route::get('/', [CustomerController::class, 'index'])->name('customer');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    });

    Route::group(['prefix'=>'service_category'], function(){
        Route::get('/', [ServiceCategoryController::class, 'index'])->name('service_category');
        Route::get('/create', [ServiceCategoryController::class, 'create'])->name('service_category.create');
        Route::post('/store', [ServiceCategoryController::class, 'store'])->name('service_category.store');
        Route::get('/edit/{id}', [ServiceCategoryController::class, 'edit'])->name('service_category.edit');
        Route::post('/update/{id}', [ServiceCategoryController::class, 'update'])->name('service_category.update');
        Route::get('/delete/{id}', [ServiceCategoryController::class, 'delete'])->name('service_category.delete');
    });

    Route::group(['prefix'=>'service'], function(){
        Route::get('/', [ServiceController::class, 'index'])->name('service');
        Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::get('/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
    });

    Route::group(['prefix'=>'order'], function(){
        Route::get('/', [OrderController::class, 'index'])->name('order');
        Route::get('/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/store', [OrderController::class, 'store'])->name('order.store');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
        Route::get('/pagination', [OrderController::class, 'create'])->name('order.pagination');
        Route::get('/add-to-cart/{id}', [OrderController::class, 'add_to_cart'])->name('order.addToCart');
        Route::get('/change_status/{id}', [OrderController::class, 'change_status'])->name('order.change_satus');
        Route::post('/change_status/{id}', [OrderController::class, 'update_status'])->name('order.update_status');
        Route::get('/pay_term/{id}', [OrderController::class, 'payment'])->name('order.pay_term');
        Route::post('/pay_term/{id}', [OrderController::class, 'update_payment'])->name('order.update_pay_term');
        Route::get('/print_slip/{id}', [OrderController::class, 'print_pack_slip'])->name('order.print_slip');
    });

    Route::group(['prefix'=>'expense_category'], function(){
        Route::get('/', [ExpenseCategoryController::class, 'index'])->name('expenseCategory');
        Route::get('/create', [ExpenseCategoryController::class, 'create'])->name('expenseCategory.create');
        Route::post('/store', [ExpenseCategoryController::class, 'store'])->name('expenseCategory.store');
        Route::get('/edit/{id}', [ExpenseCategoryController::class, 'edit'])->name('expenseCategory.edit');
        Route::post('/update/{id}', [ExpenseCategoryController::class, 'update'])->name('expenseCategory.update');
        Route::get('/delete/{id}', [ExpenseCategoryController::class, 'delete'])->name('expenseCategory.delete');
    });

    Route::group(['prefix'=>'expense'], function(){
        Route::get('/', [ExpenseController::class, 'index'])->name('expense');
        Route::get('/create', [ExpenseController::class, 'create'])->name('expense.create');
        Route::post('/store', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::post('/update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::get('/delete/{id}', [ExpenseController::class, 'delete'])->name('expense.delete');
    });

    Route::group(['prefix'=>'report'], function(){
        Route::get('/order_report', [ReportController::class, 'order_report'])->name('order.report');
        Route::get('/profit_loss', [ReportController::class, 'profitLoss_report'])->name('profit_loss.report');
    });

});
