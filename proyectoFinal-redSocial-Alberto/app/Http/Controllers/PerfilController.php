<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class PerfilController extends Controller
{

    public function __construct(){
        //Middleware auth para que solo los usuarios autenticados puedan editar su perfil
        $this->middleware('auth');
    }

    public function index(){
        return view('perfil.index');
    }

    public function store(Request $request){
        //Modificar el perfil
        $request->request->add(['username' => Str::slug($request->username)]);
        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 
                            'not_in:editar-perfil,login,logout,register'],
        ]);

        $usuario = User::find(auth()->user()->id);

        if ($request->hasFile('imagen')) {
            $request->validate([
                'imagen' => ['image', 'max:5120'],
            ]);

            $archivo = $request->file('imagen');
            $nombreImagen = Str::uuid() . '.' . $archivo->getClientOriginalExtension();

            // Redimensionamos suavemente para evitar que las imágenes gigantes saturen el almacenamiento
            $imagenProcesada = Image::read($archivo)->scaleDown(1000, 1000);

            $ruta = "perfiles/{$nombreImagen}";
            // Preservar el formato original de la imagen
            $extension = strtolower($archivo->getClientOriginalExtension());
            
            $contenido = match($extension) {
                'png' => (string) $imagenProcesada->toPng(),
                'gif' => (string) $imagenProcesada->toGif(),
                'webp' => (string) $imagenProcesada->toWebp(),
                default => (string) $imagenProcesada->toJpeg(),
            };
            
            Storage::disk('public')->put($ruta, $contenido);

            $usuario->imagen = $nombreImagen;
        }

        if (! $usuario->imagen) {
            $usuario->imagen = auth()->user()->imagen ?? '';
        }

        $usuario->username = $request->username;
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
