<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\SearchController;
use Symfony\Component\Routing\Route as RoutingRoute;


//Eliminamos el arreglo y el método, porque HomeController es de tipo invokable
Route::get('/', HomeController::class)->name('home');
Route::get('/buscar', SearchController::class)->name('users.search');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::resource('comments', AdminCommentController::class)->except(['show']);
});

/*
    Después de cada una de las rutas que hemos definido añadimo name. 
    Esto nos permitirá identificar la ruta de una manera más sencilla a la hora de generar URLs o redireccionar.
*/

//Rutas para el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

//Rutas para el registro
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//Rutas para el login y logout
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

//Rutas para controlar los posts
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

//Rutas para el control de comentarios
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

//Rutas para las imagenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//Like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.like.store');
//Quitar like a las fotos
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.like.destroy');

//Siguiendo usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

