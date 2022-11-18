<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTagController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\ChangePasswordController;

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

/* *Route::get('/', function () {
    return view('welcome');
}); */

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    //Route::get('/', 'HomeController@index')->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Permissions
    //Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    //Route::resource('permissions', 'PermissionsController');

    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    //Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    //Route::resource('roles', 'RolesController');

    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    //Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    //Route::resource('users', 'UsersController');

    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // Product Category
    /*Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');*/

    Route::delete('product-categories/destroy', [ProductCategoryController::class, 'massDestroy'])->name('product-categories.massDestroy');
    Route::post('product-categories/media', [ProductCategoryController::class, 'storeMedia'])->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', [ProductCategoryController::class, 'storeCKEditorImages'])->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', ProductCategoryController::class);

    // Product Tag
    //Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    //Route::resource('product-tags', 'ProductTagController');

    Route::delete('product-tags/destroy', [ProductTagController::class, 'massDestroy'])->name('product-tags.massDestroy');
    Route::resource('product-tags', ProductTagController::class);

    // Product
    /*Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');*/

    Route::delete('products/destroy', [ProductController::class, 'massDestroy'])->name('products.massDestroy');
    Route::post('products/media', [ProductController::class, 'storeMedia'])->name('products.storeMedia');
    Route::post('products/ckmedia', [ProductController::class, 'storeCKEditorImages'])->name('products.storeCKEditorImages');
    Route::resource('products', ProductController::class);
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        /*Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');*/

        Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');

    }
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
