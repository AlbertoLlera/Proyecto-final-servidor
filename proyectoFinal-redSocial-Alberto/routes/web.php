<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use Symfony\Component\Routing\Route as RoutingRoute;

Route::get('/', function () {
    return view('principal');
});

/*
    Después de cada una de las rutas que hemos definido añadimo name. 
    Esto nos permitirá identificar la ruta de una manera más sencilla a la hora de generar URLs o redireccionar.
*/
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');