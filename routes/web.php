<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TypesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'home']);

	Route::prefix('types')->group(function () {
		Route::get('/', [TypesController::class, 'index'])->name('indexTypes');
		Route::post('/', [TypesController::class, 'store'])->name('storeTypes');
		Route::put('/{id}', [TypesController::class, 'update'])->name('updateTypes');
		Route::delete('/{id}', [TypesController::class, 'destroy'])->name('destroyTypes');
	});
	Route::prefix('products')->group(function () {
		Route::get('/', [ProductsController::class, 'index'])->name('indexProducts');
		Route::get('/add', [ProductsController::class, 'addIndex'])->name('addIndexProducts');
		Route::get('/edit/{id}', [ProductsController::class, 'editIndex'])->name('editIndexProducts');
		Route::post('/', [ProductsController::class, 'store'])->name('storeProducts');
		Route::put('/{id}', [ProductsController::class, 'update'])->name('updateProducts');
		Route::post('/images/{id}', [ProductsController::class, 'uploadImages'])->name('uploadProductImages');
		Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('destroyProducts');
	});

	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	// Route::get('types', function () {
	// 	return view('layouts/pages/master-data/types/index');
	// })->name('types');

	Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

	Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

	Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

	Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
	Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
	Route::get('/register', [RegisterController::class, 'create']);
	Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');
