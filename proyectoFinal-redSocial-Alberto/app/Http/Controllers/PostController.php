<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Mime\Part\File;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        /*
        Middleware auth para que solo los usuarios autenticados puedan crear posts.
        Sin embargo, con el metodo except lo que indicamos es las únicas rutas que no necesitan autenticación
        , por tanto, a la que podrán acceder los usuarios que no tienen una sesión iniciada o una cuenta como tal.
        */
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index (User $user) {

        //Get al final es importante para que extraiga los datos del usuario
        $posts = Post::where('user_id', $user->id)->paginate(20);

        //La vista está recibiendo dos variables y en cada una de ellas un objeto con los datos del usuario y del post
      return view('dashboard', [
          'user' => $user,
          'posts' => $posts,
      ]);
    }

    //Devuelve la vista para poder crear un post
    public function create (){
        return view('posts.create');
    }

    //Almacena en la base de datos los posts de los usurios
    public function store (Request $request){
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required|string'
        ]);

        /*Almacenar el post 
        Post::create([
            'titulo' => $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id,
        ]);
        */

        //Otra forma de almacenar el post pero esta vez aprovechando la relación que hemos creado en el modelo User
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('posts.index', auth()->user()->username);

    }

    public function show (User $user, Post $post){
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post){
        //Utilizamos el método authorize para verificar la política definida en PostPolicy
        $this->authorize('delete', $post);

        //Elimnamos la imagen a la vez que el post
        $imagen_path = public_path('uploads/' . $post->imagen);

        if (file_exists($imagen_path)){
            unlink($imagen_path);
            File::delete($imagen_path);
        }

        //Borramos y redirigimos a su muro
        $post->delete();
        return redirect()->route('posts.index', auth()->user()->username);
    }
    
}