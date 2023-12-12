<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Social\google\GoogleAuthController;
//admin
use App\Http\Controllers\Admin\Dashboard\AdminDashboardController;

//customer
use App\Http\Controllers\Customer\Dashboard\CustomerDashboardController;


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

Auth::routes();


//google login 
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('googleLoginForm');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('handleGoogleCallback');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //login
    // Route::get('/login', [AuthController::class, 'Login'])->name('login');

    Route::middleware(['admin', 'auth'])->group(function () {

        //dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'AdminDashboard'])->name('dashboard');

        //notifications
        Route::get('/read_notification/{id}', [AdminDashboardController::class, 'ReadNotification'])->name('ReadNotification');
       

    });
});

//Customer Routes
Route::group(['prefix' => 'customer', 'as' => 'customer.', 'middleware' => 'customer', 'middleware' => 'auth'], function () {   
     
      Route::get('/dashboard', [CustomerDashboardController::class, 'CustomerDashboard'])->name('dashboard');
 });

