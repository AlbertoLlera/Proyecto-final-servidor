@extends('layouts.app')

@section('titulo')
    Administración · Comentarios
@endsection

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600 text-sm">Modera conversaciones y elimina reportes.</p>
        <a href="{{ route('admin.comments.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Nuevo comentario</a>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Extracto</th>
                    <th class="px-4 py-3">Autor</th>
                    <th class="px-4 py-3">Post</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($comments as $comment)
                    <tr>
                        <td class="px-4 py-3 text-gray-700">{{ \Illuminate\Support\Str::limit($comment->comentario, 60) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($comment->user)->name ?? 'Usuario eliminado' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($comment->post)->titulo ?? 'Post eliminado' }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('admin.comments.edit', $comment) }}" class="text-sm text-blue-600 font-semibold">Editar</a>
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('¿Eliminar este comentario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 font-semibold">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">No hay comentarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $comments->links('pagination::tailwind') }}
    </div>
@endsection
