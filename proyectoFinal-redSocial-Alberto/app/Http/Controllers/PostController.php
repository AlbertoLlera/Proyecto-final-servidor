<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        $this->middleware('auth');
    }

    public function index (User $user) {

       return view('dashboard', [
            'user' => $user
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
            'imagen' => 'required'
        ]);
    }
    
}