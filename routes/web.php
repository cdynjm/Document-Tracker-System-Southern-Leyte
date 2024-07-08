<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\OfficeController; 
use App\Http\Controllers\UserController; 

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

Route::get('/', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

Route::group(['middleware' => 'auth'], function () {

	Route::group(['middleware' => 'admin'], function () {
		Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
		Route::get('/offices', [AdminController::class, 'offices'])->name('offices');
		Route::get('/office-sections', [AdminController::class, 'officeSections'])->name('office-sections');
		Route::get('/office-accounts', [AdminController::class, 'officeAccounts'])->name('office-accounts');
		Route::get('/user-accounts', [AdminController::class, 'userAccounts'])->name('user-accounts');
		Route::get('/edit-office-account/{id}', [AdminController::class, 'editOfficeAccount'])->name('edit-office-account');
		Route::get('/admin-profile', [AdminController::class, 'profile'])->name('admin-profile');
	});

	Route::group(['middleware' => 'office'], function () {
		Route::get('/office-dashboard', [OfficeController::class, 'dashboard'])->name('office-dashboard');
		Route::get('/archives', [OfficeController::class, 'archives'])->name('archives');
		Route::get('/office-document-tracker/{id}', [OfficeController::class, 'officeDocumentTracker'])->name('office-document-tracker');
		Route::get('/office-profile', [OfficeController::class, 'profile'])->name('office-profile');
	});

	Route::group(['middleware' => 'user'], function () {
		Route::get('/user-dashboard', [UserController::class, 'dashboard'])->name('user-dashboard');
		Route::get('/directory-offices/{id}', [UserController::class, 'offices'])->name('directory-offices');
		Route::get('/user-profile', [UserController::class, 'profile'])->name('user-profile');
	});
	
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});