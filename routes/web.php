<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\BookRequestController;
use App\Http\Controllers\ChallanController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route::resource('book', BookController::class);
    Route::get('book', [BookController::class, 'index'])->name('book.index');
    Route::post('book', [BookController::class, 'store'])->name('book.store');
    Route::get('book/delete/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::get('book/show/{id}', [BookController::class, 'show'])->name('book.show');
    Route::post('book/update', [BookController::class, 'update'])->name('book.update');
    Route::get('book-stock',[BookController::class, 'bookStock'])->name('book.stock');

    
    Route::resource('roles', RolesController::class);
    Route::resource('admins', AdminsController::class);

    // Login Routes.
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

    // Logout Routes.
    Route::post('/logout/submit', [LoginController::class, 'logout'])->name('logout.submit');

    //profile Routes
    Route::get('/profile', [AdminsController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AdminsController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile-user/update', [AdminsController::class, 'update_subadmin'])->name('profileuser.update');


    // Forget Password Routes.
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset/submit', [ForgotPasswordController::class, 'reset'])->name('password.update');
})->middleware('auth:admin');


Route::middleware(['auth'])->group(function () {
    Route::get('book-requests/create', [BookRequestController::class, 'create'])->name('book-requests.create');
    Route::get('book-requests/index', [BookRequestController::class, 'index'])->name('book-requests.index');
    Route::post('/book-requests', [BookRequestController::class, 'store'])->name('book-requests.store');
    Route::get('/book-requests-view', [BookRequestController::class, 'request_view'])->name('book-requests.view');  //for see own sent request
    Route::get('/book-requests', [BookRequestController::class, 'request_view'])->name('request_view'); // see approved/declined req
    Route::post('book-requests/{id}/approve', [BookRequestController::class, 'updateStatusapprove'])->name('book-requests.approve');
    Route::post('book-requests/{id}/decline', [BookRequestController::class, 'updateStatusdecline'])->name('book-requests.decline');
    Route::get('book-requests/alc-distribution', [BookRequestController::class, 'alcDistribution'])->name('book-requests.alc-distribution');


    Route::get('/book-requests/{id}/challan', [BookRequestController::class, 'generateChallan'])->name('book-requests.challan.generate');
    // Route::get('/challans', [ChallanController::class, 'viewChallans'])->name('challans.index');
    Route::get('challans', [ChallanController::class, 'index'])->name('challans.index');
    Route::get('/challans/{id}/pdf', [BookRequestController::class, 'generateChallan'])->name('challans.challan.pdf');
    Route::get('generate-pdf', [challanController::class, 'generatePdf'])->name('generate-pdf');

    //mail
    route::get('send-email-pdf', [ChallanController::class, 'mail']);

});

