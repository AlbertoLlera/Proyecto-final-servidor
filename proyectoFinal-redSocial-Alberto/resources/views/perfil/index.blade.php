@extends('layouts.app')

@section('titulo')

    Editar Perfil: {{ auth()->user()->username }}
    
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{ route('perfil.store') }}" method="POST" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb block uppercase text-gray-500 font-bold">Nombre de usuario</label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        placeholder="Tu nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{auth()->user()->username}}"
                    />
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb block uppercase text-gray-500 font-bold">Imagen perfil</label>
                    <input
                        id="imagen"
                        name="imagen"
                        type="file"
                        class="border p-3 w-full rounded-lg"
                        value="{{auth()->user()->imagen}}"
                        accept=".jpg, .png, .gif"
                    />
                </div>

                <input type="submit" 
                    value="Actualizar Perfil" 
                    class="bg-sky-600 hover:bg-sky-700 transition-color cursor-pointer 
                    uppercase font-bold w-full p-3 text-white rounded-lg"
                >

            </form>
        </div>
    </div>
@endsection