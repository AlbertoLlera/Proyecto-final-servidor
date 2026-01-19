<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'image', 'max:5120'],
        ]);

        $archivo = $validated['file'];
        $nombreImagen = Str::uuid() . '.' . $archivo->getClientOriginalExtension();

        // Redimensionamos suavemente para evitar que las imágenes gigantes saturen el almacenamiento
        $imagenProcesada = Image::read($archivo)->scaleDown(1200, 1200);

        $ruta = "uploads/{$nombreImagen}";
        $contenido = $imagenProcesada->encodeByPath($nombreImagen);
        Storage::disk('public')->put($ruta, (string) $contenido);

        return response()->json(['imagen' => $nombreImagen], 201);
    }
}
