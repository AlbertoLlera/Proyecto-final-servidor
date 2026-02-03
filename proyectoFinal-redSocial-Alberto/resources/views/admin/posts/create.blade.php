@extends('layouts.app')

@section('titulo')
    Nueva publicación
@endsection

@section('contenido')
    <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-xl p-6 space-y-6">
        <form action="{{ route('admin.posts.store') }}" method="POST" class="space-y-6">
            @include('admin.posts._form')

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-semibold">Guardar</button>
            </div>
        </form>
    </div>
@endsection
