<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/admin', function () {
//     return view('admin.dashboard');
// })->middleware('auth')->name('admin.dashboard');

//Usuarios
Route::get('/usuarios', [UserController::class, 'index'])->middleware('can:admin.index')->name('users.index');
Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->middleware('can:admin.edit')->name('users.edit');
Route::put('/usuarios/{user}', [UserController::class, 'update'])->middleware('can:admin.update')->name('users.update');

//Roles 
Route::get('/roles', [RoleController::class, 'index'])->middleware('can:admin.index')->name('roles.index');
Route::get('/roles/crear', [RoleController::class, 'create'])->middleware('can:admin.create')->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->middleware('can:admin.store')->name('roles.store');
Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('can:admin.show')->name('roles.show');
Route::get('/roles/{role}/editar', [RoleController::class, 'edit'])->middleware('can:admin.edit')->name('roles.edit');
Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('can:admin.update')->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('can:admin.destroy')->name('roles.destroy');
//Categorias 
Route::get('/categorias', [CategoryController::class, 'index'])->middleware('can:admin.index')->name('categories.index');
Route::get('/categorias/crear', [CategoryController::class, 'create'])->middleware('can:admin.create')->name('categories.create');
Route::post('/categorias', [CategoryController::class, 'store'])->middleware('can:admin.store')->name('categories.store');
Route::get('/categorias/{category}', [CategoryController::class, 'show'])->middleware('can:admin.show')->name('categories.show');
Route::get('/categorias/{category}/editar', [CategoryController::class, 'edit'])->middleware('can:admin.edit')->name('categories.edit');
Route::put('/categorias/{category}', [CategoryController::class, 'update'])->middleware('can:admin.update')->name('categories.update');
Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->middleware('can:admin.destroy')->name('categories.destroy');

//Subcategorias
Route::get('/subcategorias', [SubCategoryController::class, 'index'])->middleware('can:admin.index')->name('subcategories.index');
Route::get('/subcategorias/crear', [SubCategoryController::class, 'create'])->middleware('can:admin.create')->name('subcategories.create');
Route::post('/subcategorias', [SubCategoryController::class, 'store'])->middleware('can:admin.store')->name('subcategories.store');
Route::get('/subcategorias/{subcategory}', [SubCategoryController::class, 'show'])->middleware('can:admin.show')->name('subcategories.show');
Route::get('/subcategorias/{subcategory}/editar', [SubCategoryController::class, 'edit'])->middleware('can:admin.edit')->name('subcategories.edit');
Route::put('/subcategorias/{subcategory}', [SubCategoryController::class, 'update'])->middleware('can:admin.update')->name('subcategories.update');
Route::delete('/subcategorias/{subcategory}', [SubCategoryController::class, 'destroy'])->middleware('can:admin.destroy')->name('subcategories.destroy');

//Productos
Route::get('/productos', [ProductController::class, 'index'])->middleware('can:admin.index')->name('products.index');
Route::get('/productos/crear', [ProductController::class, 'create'])->middleware('can:admin.create')->name('products.create');
Route::post('/productos', [ProductController::class, 'store'])->middleware('can:admin.store')->name('products.store');
Route::get('/productos/{product}', [ProductController::class, 'show'])->middleware('can:admin.show')->name('products.show');
Route::get('/productos/{product}/editar', [ProductController::class, 'edit'])->middleware('can:admin.edit')->name('products.edit');
Route::put('/productos/{product}', [ProductController::class, 'update'])->middleware('can:admin.update')->name('products.update');  
Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->middleware('can:admin.destroy')->name('products.destroy');
