<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChildrenCatController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImageUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\roles\RolesController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\users\UserController;
use App\Http\Resources\categoryResource;
use App\Http\Resources\postResource;
use App\Http\Resources\TagCollection;
use App\Http\Resources\tagResource;
use App\Models\category;
use App\Models\Post;
use App\Models\product;
use App\Models\tag;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

    //? Web Routes
    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']], function(){

        //* The first page in the dashboard
        Route::get('/', function () {
            return view('auth.login');
        });

        //! other page
        // Route::get('{page}', [AdminController::class, 'index']);

        //* The first page in the dashboard after logging in
        Route::get('dashboard', function () {
            //* Start Statistical
                $chartjs = app()->chartjs
                ->name('barChartTest')
                ->type('bar')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Posts', 'Products'])
                ->datasets([
                    [
                        "label" => "Posts",
                        'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                        'data' => [69, 59]
                    ],
                    [
                        "label" => "Products",
                        'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                        'data' => [65, 12]
                    ]
                ])
                ->options([]);
            //* End Statistical
            return view('index', compact('chartjs'));
        })->middleware(['auth', 'verified'])->name('dashboard');

        //* To access these pages, you must log in first
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
                Route::delete('/deleteallpost', [PostController::class, 'deleteallpost'])->name('post_tags.deleteallpost');
            });

            Route::prefix('tags')->group(function (){
                Route::get('/tag', [TagController::class, 'index'])->name('tags_index');
                Route::post('/createtag', [TagController::class, 'store'])->name('tags.create');
                Route::patch('/updatetag', [TagController::class, 'update'])->name('tags.update');
                Route::delete('/deletetag', [TagController::class, 'delete'])->name('tags.delete');
                Route::get('/tag_posts/{id}', [TagController::class, 'tag_posts']);
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

            Route::prefix('posts')->group(function (){
                Route::get('/post', [PostController::class, 'index'])->name('posts_index');
                Route::get('/linkcreatepost', [PostController::class, 'create'])->name('linkposts.createpost');
                Route::post('/createpost', [PostController::class, 'store'])->name('posts.create');
                Route::patch('/updatepost', [PostController::class, 'update'])->name('posts.update');
                Route::delete('/deletepost', [PostController::class, 'delete'])->name('posts.delete');
                Route::get('/posts/editstatusdéactive/{id}', [PostController::class, 'editstatusdéactive'])->name('posts.editstatusdéactive');
                Route::get('/posts/editstatusactive/{id}', [PostController::class, 'editstatusactive'])->name('posts.editstatusactive');
                Route::get('/page_detailsposts/{id}', [PostController::class, 'detailsposts'])->name('page_detailsposts');
                Route::get('/page_details/{id}', [PostController::class, 'page_details'])->name('page_details');
                Route::get('Notification/markAdRead', [PostController::class, 'markeAsRead'])->name('Notification.Read');
            });
            Route::get('/category/{id}', [PostController::class, 'getchild']);

            Route::prefix('products')->group(function (){
                Route::get('/product', [ProductController::class, 'index'])->name('product_index');
                Route::get('/linkcreateproduct', [ProductController::class, 'create'])->name('product.createprod');
                Route::post('/createproduct', [ProductController::class, 'store'])->name('product.create');
                Route::patch('/updateproduct', [ProductController::class, 'update'])->name('product.update');
                Route::delete('/deleteproduct', [ProductController::class, 'delete'])->name('product.delete');
                Route::get('/products/editstatusdéactive/{id}', [ProductController::class, 'editstatusdéactive'])->name('products.editstatusdéactive');
                Route::get('/products/editstatusactive/{id}', [ProductController::class, 'editstatusactive'])->name('products.editstatusactive');
            });
            Route::get('/categoryproduct/{id}', [ProductController::class, 'getchildproduct']);

            Route::prefix('images')->group(function (){
                Route::get('/images/{id}', [ImageController::class, 'index']);
                Route::post('/createimage', [ImageController::class, 'store'])->name('image.create');
                Route::delete('/deleteimage', [ImageController::class, 'delete'])->name('image.delete');
            });

            Route::prefix('product_color')->group(function (){
                Route::get('/product_color/{id}', [ProductColorController::class, 'index']);
                Route::post('/createproduct_color', [ProductColorController::class, 'store'])->name('product_color.create');
                Route::delete('/deleteproduct_color', [ProductColorController::class, 'delete'])->name('product_color.delete');
            });

            Route::prefix('sizes')->group(function (){
                Route::get('/sizes/{id}', [SizeController::class, 'index']);
                Route::patch('/size', [SizeController::class, 'update'])->name('sizes.update');
            });

            Route::prefix('promotions')->group(function (){
                Route::get('/promotions/{id}', [PromotionController::class, 'index']);
                Route::post('/createpromotion', [PromotionController::class, 'store'])->name('promotions.create');
                Route::patch('/promotionupdate', [PromotionController::class, 'update'])->name('promotions.update');
                Route::get('/promotions/editstatusdéactive/{id}', [PromotionController::class, 'editstatusdéactive'])->name('promotions.editstatusdéactive');
                Route::get('/promotions/editstatusactive/{id}', [PromotionController::class, 'editstatusactive'])->name('promotions.editstatusactive');
                Route::delete('/deletepromotion', [PromotionController::class, 'delete'])->name('promotion.delete');
            });

            Route::prefix('page_cart')->group(function (){
                Route::post('/page_cart/{id}', [CartController::class, 'store'])->name('page_add_cart');
                Route::patch('/page_cart_update', [CartController::class, 'update'])->name('page_cart_update');
                Route::get('/page_cart_delete/{id}', [CartController::class, 'delete'])->name('page_cart_delete');
                Route::get('/page_cart_deleteall', [CartController::class, 'deleteall'])->name('page_cart_deleteall');
            });

            // Route::get('/scout', function(){
            //     return product::search('wwww')->get();
            // });
        });

        //* Login With Github
        Route::get('login-github', [SocialiteController::class, 'redirectToProviderGithub'])->name('github.login');
        Route::get('/auth/callback', [SocialiteController::class, 'handleCallbackGithub'])->name('github.login.callback');

        require __DIR__.'/auth.php';

    });

    /* Resource Tag  */
    Route::get('/tag/{id}', function ($id) {
        return new tagResource(tag::findOrFail($id));
    });

    Route::get('/tags', function () {
        return tagResource::collection(tag::all());
    });

    Route::get('/tagscollection', function () {
        return new TagCollection(tag::all());
    });


    Route::get('/tagsPreserveKeys', function () {
        return tagResource::collection(tag::all()->keyBy->id);
    });

    /* Resource Catgeory  */
    Route::get('/catgeories', function () {
        return categoryResource::collection(category::all()->keyBy->id);
    });

    /* Resource Post  */
    Route::get('/posts', function () {
        return postResource::collection(Post::all()->keyBy->id);
    });
