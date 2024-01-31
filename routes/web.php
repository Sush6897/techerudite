<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PasswordResetController;
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

Route::get('/', function () {
   return redirect()->route('user.register');
});

Route::get('/userregister',[RegistrationController::class,"index"])->name('user.register');
Route::post('/userregister',[RegistrationController::class,"register"])->name('user.post');

Route::get('/verify-email/{id}', [RegistrationController::class, 'verifyEmail'])->name('verify.email');

Route::get('/login', [RegistrationController::class, 'login'])->name('login');

Route::get('/userlogin', [RegistrationController::class, 'userlogin'])->name('user.login');
Route::post('/userlogin',[RegistrationController::class,"userpost"])->name('user.login.post');

// user.login.post
Route::post('/login',[RegistrationController::class,"loginpost"])->name('login.post');

Route::get('/adminregister',[RegistrationController::class,"adminregister"])->name('admin.register');

Route::get('/dashboard', [RegistrationController::class, "dashboard"])->name('dashboard');


Route::post('/logout',[RegistrationController::class, 'logout'])->name('logout');


Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('forgot-password', [PasswordResetController::class, 'sendPasswordResetLink']);

Route::get('reset-password/{email}/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);