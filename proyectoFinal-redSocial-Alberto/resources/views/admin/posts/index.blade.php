@extends('layouts.app')

@section('titulo')
    Administración · Publicaciones
@endsection

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600 text-sm">Controla lo que se publica en la comunidad.</p>
        <a href="{{ route('admin.posts.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Nueva publicación</a>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Título</th>
                    <th class="px-4 py-3">Autor</th>
                    <th class="px-4 py-3">Creado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($posts as $post)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $post->titulo }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($post->user)->name ?? 'Usuario eliminado' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm text-blue-600 font-semibold">Editar</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Eliminar esta publicación?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 font-semibold">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">No encontramos publicaciones.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links('pagination::tailwind') }}
    </div>
@endsection
