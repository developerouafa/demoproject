<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChildrenCatController;
use App\Http\Controllers\ImageUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\roles\RolesController;
use App\Http\Controllers\TagController;
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
                Route::patch('/updateprofile', [ProfileController::class, 'updateprofile'])->name('profile.updateprofile');
                Route::patch('/updatemail', [ProfileController::class, 'updatemail'])->name('profile.updatemail');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                Route::get('destroy', [AuthenticatedSessionController::class, 'destroy'])->name('auth.destroy');
                Route::resource('roles', RolesController::class);
                Route::resource('users', UserController::class);
                    Route::prefix('imageuser')->group(function (){
                        Route::post('/imageuser', [ImageUserController::class, 'store'])->name('imageuser.store');
                        Route::patch('/imageuser', [ImageUserController::class, 'update'])->name('imageuser.update');
                        Route::get('/imageuser', [ImageUserController::class, 'destroy'])->name('imageuser.delete');
                    });

                    Route::prefix('posts')->group(function (){
                        Route::get('/post', [PostController::class, 'index'])->name('posts_index');
                        Route::get('/linkcreatepost', [PostController::class, 'create'])->name('linkposts.createpost');
                        Route::post('/createpost', [PostController::class, 'store'])->name('posts.create');
                        Route::patch('/updatepost', [PostController::class, 'update'])->name('posts.update');
                        Route::delete('/deletepost', [PostController::class, 'delete'])->name('posts.delete');
                    });

                    Route::prefix('tags')->group(function (){
                        Route::get('/tag', [TagController::class, 'index'])->name('tags_index');
                        Route::post('/createtag', [TagController::class, 'store'])->name('tags.create');
                        Route::patch('/updatetag', [TagController::class, 'update'])->name('tags.update');
                        Route::delete('/deletetag', [TagController::class, 'delete'])->name('tags.delete');
                        // Route::get('/tag_posts/{id}', [TagController::class, 'tag_posts']);
                    });

                    Route::prefix('post_tags')->group(function (){
                        Route::get('/post_tags/{id}', [PostTagController::class, 'index']);
                        Route::get('/post_tagsupdate/{id}', [PostTagController::class, 'update']);
                        Route::post('/createpost_tags', [PostTagController::class, 'store'])->name('post_tags.create');
                        Route::patch('/updatepost_tags', [PostTagController::class, 'update'])->name('post_tags.update');
                        Route::delete('/deletepost_tags/{id}', [PostTagController::class, 'delete'])->name('post_tags.delete');
                    });

                    Route::prefix('categories')->group(function (){
                        Route::get('/category', [CategoryController::class, 'index'])->name('category_index');
                        Route::post('/createcat', [CategoryController::class, 'store'])->name('categories.create');
                        Route::get('/categories/editstatusdéactive/{id}', [CategoryController::class, 'editstatusdéactive'])->name('categories.editstatusdéactive');
                        Route::get('/categories/editstatusactive/{id}', [CategoryController::class, 'editstatusactive'])->name('categories.editstatusactive');
                        Route::patch('/updatecat', [CategoryController::class, 'update'])->name('categories.update');
                        Route::delete('/deletecat', [CategoryController::class, 'delete'])->name('categories.delete');
                    });

                    Route::prefix('children')->group(function (){
                        Route::get('/child', [ChildrenCatController::class, 'index'])->name('childcat_index');
                        Route::post('/createchild', [ChildrenCatController::class, 'store'])->name('childcat.create');
                        Route::patch('/updatechild', [ChildrenCatController::class, 'update'])->name('childcat.update');
                        Route::delete('/deletechild', [ChildrenCatController::class, 'delete'])->name('childcat.delete');
                    });
            });

            Route::get('login-github', [SocialiteController::class, 'redirectToProviderGithub'])->name('github.login');
            Route::get('/auth/callback', [SocialiteController::class, 'handleCallbackGithub'])->name('github.login.callback');

            require __DIR__.'/auth.php';

        // });
    });
