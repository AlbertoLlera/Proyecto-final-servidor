@extends('layouts.app')

@section('titulo')
    Editar publicación
@endsection

@section('contenido')
    <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-xl p-6 space-y-6">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="space-y-6">
            @method('PUT')
            @include('admin.posts._form')

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-500">Volver al listado</a>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-semibold">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
