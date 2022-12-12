<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ImageUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\roles\RolesController;
use App\Http\Controllers\users\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

    // Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
    //     // Route::group(['prefix' => 'offers'], function (){
    //         Route::get('/', function () {
    //             return view('auth.login');
    //         });
    //         // Route::get('{page}', [AdminController::class, 'index']);

    //         Route::middleware('auth')->group(function () {
    //             Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //             Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //             Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //         });

    //         Route::get('login-github', [SocialiteController::class, 'redirectToProviderGithub'])->name('github.login');
    //         Route::get('/auth/callback', [SocialiteController::class, 'handleCallbackGithub'])->name('github.login.callback');

    //         Route::get('destroy', [AuthenticatedSessionController::class, 'destroy'])->name('auth.destroy');

    //         require __DIR__.'/auth.php';

    //         Route::get('dashboard', function () {
    //             return view('index');
    //         })->middleware(['auth', 'verified'])->name('dashboard');

    //         Route::resource('roles', RolesController::class);
    //         Route::resource('users', UserController::class);
    //     // });
    // });

    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']], function(){
        // Route::group(['prefix' => 'offers'], function (){
            Route::get('/', function () {
                return view('auth.login');
            });
            // Route::get('{page}', [AdminController::class, 'index']);
            Route::get('dashboard', function () {
                return view('index');
            })->middleware(['auth', 'verified'])->name('dashboard');

            Route::middleware(['auth', 'verified'])->group(function () {
                Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                Route::get('destroy', [AuthenticatedSessionController::class, 'destroy'])->name('auth.destroy');
                Route::resource('roles', RolesController::class);
                Route::resource('users', UserController::class);
                    Route::prefix('imageuser')->group(function (){
                        Route::post('/imageuser', [ImageUserController::class, 'store'])->name('imageuser.store');
                        Route::patch('/imageuser', [ImageUserController::class, 'update'])->name('imageuser.update');
                        Route::get('/imageuser', [ImageUserController::class, 'destroy'])->name('imageuser.delete');
                    });

            });


            Route::get('login-github', [SocialiteController::class, 'redirectToProviderGithub'])->name('github.login');
            Route::get('/auth/callback', [SocialiteController::class, 'handleCallbackGithub'])->name('github.login.callback');

            require __DIR__.'/auth.php';

        // });
    });
