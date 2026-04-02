<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MtIssueController;
use App\Http\Controllers\CommentController;





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
    return view('auth.login');
});


// Halaman login dan logout
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman registrasi
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');



Route::middleware(['auth'])->group(function () {
    
    Route::get('/search', [MtIssueController::class, 'search'])->name('users.search');
    Route::resource('departements', DepartementController::class);
    Route::resource('roles', controller: RoleController::class);
    Route::resource('positions', controller: PositionController::class);
    Route::resource('users', controller: UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    // Route::resource('mt_issues', MtIssueController::class);
    // Route::get('/issues/{id}/edit', [MtIssueController::class, 'edit'])->name('issues.edit');
    Route::get('/issues/{id}', [MtIssueController::class, 'show'])->name('issues.show');
    Route::get('/redirect', [UserController::class, 'redirectBasedOnRole'])->name('users.redirect');

    Route::put('/mt_issues/{id}', [MtIssueController::class, 'update'])->name('mt_issues.update');

    Route::put('/issues/{id}', [MtIssueController::class, 'update'])->name('issues.update');

    Route::get('/issues/{issue}/edit', [MtIssueController::class, 'edit'])
    ->name('issues.edit')
    ->middleware('role:Admin'); 
    // Route::get('/dashboard', [HomeController::class, 'index']);
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.index');

    
    Route::get('/mt_issues', [MtIssueController::class, 'index'])->name('mt_issues.index');
    Route::get('/mt_issues/tag', [MtIssueController::class, 'indexTag'])->name('mt_issues.tag');
    Route::get('/mt_issues/{id}/show', [MtIssueController::class, 'show'])->name('mt_issues.show');
    Route::get('/issues/{id}', [MtIssueController::class, 'show'])->name('issues.show');
    Route::get('/mt_issues/create', [MtIssueController::class, 'create'])->name('mt_issues.create');
    Route::post('/mt_issues', [MtIssueController::class, 'store'])->name('mt_issues.store');Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/issues/{issue}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');  
    Route::delete('/issues/{id}', [MtIssueController::class, 'destroy'])->name('issues.destroy');
    Route::get('/pelaporan', [PelaporanController::class, 'index'])->name('pelaporan.index');
    Route::get('/pelaporan/download', [PelaporanController::class, 'download'])->name('pelaporan.download');
    Route::patch('/issues/{id}/close', [MtIssueController::class, 'close'])->name('issues.close');
  
    Route::get('/panduan', function () {
        return view('panduan.index');
    })->name('panduan.index');
     
});