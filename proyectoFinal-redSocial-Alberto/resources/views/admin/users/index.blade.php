@extends('layouts.app')

@section('titulo')
    Administración · Usuarios
@endsection

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600 text-sm">Gestiona altas, bajas y roles de los miembros.</p>
        <a href="{{ route('admin.users.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Nuevo usuario</a>
    </div>

    <!-- Barra de búsqueda -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nombre, usuario o correo..." 
                    value="{{ $search ?? '' }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                >
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold">
                Buscar
            </button>
            @if ($search)
                <a href="{{ route('admin.users.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg text-sm font-semibold">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Usuario</th>
                    <th class="px-4 py-3">Correo</th>
                    <th class="px-4 py-3">Rol</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->username }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-sm text-blue-600 font-semibold">Editar</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 font-semibold">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Todavía no hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links('pagination::tailwind') }}
    </div>
@endsection
