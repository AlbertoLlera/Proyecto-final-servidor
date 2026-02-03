<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct(){
        //Middleware auth para que solo los usuarios autenticados puedan ver el home
        $this->middleware('auth');
    }

    /*
    Solo tenemos un método en este controlador, por eso lo hacemos de tipo controlador.
    Es como un cosntructor, inmediatamente se manda llamar al controlador y se ejecuta el método.
    */

    public function __invoke(){
        //Obtenemos la vista de las personas que seguimos

        $ids = auth()->user()->following->pluck('id')->toArray();
        //La siguiente líne es para traer los posts de los usuarios que seguimos. Latest te muestra las últimas publicaciones primero
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        return view('home', [
            'posts' => $posts
        ]);
    }
}
