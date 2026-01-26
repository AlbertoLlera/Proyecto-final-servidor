<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post){
            
            //Validamos el comentario antes de enviarlo a la base de datos
            $validated = $request->validate([
                'comentario' => 'required|max:255'
            ]);

            //Almacenamos el comentario que irá a la BBDD
            Comentario::create([
                //Usamos la utanticación para sacar el id del usuario que ha hecho un comentario
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
                'comentario' => $request->comentario
            ]);

            /*
            De esta manera redirigimos al usuario a la misma página del post una vez realizado el comentario.
            Así como le indicamos también que su mensaje se ha realizado de manera exitosa. 
            */
            return back()->with('mensaje', 'Comentario realizado correctamente');

    }
}
