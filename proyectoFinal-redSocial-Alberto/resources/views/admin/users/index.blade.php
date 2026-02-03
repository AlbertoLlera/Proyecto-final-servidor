@extends('layouts.app')

@section('titulo')
    Administración · Usuarios
@endsection

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600 text-sm">Gestiona altas, bajas y roles de los miembros.</p>
        <a href="{{ route('admin.users.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Nuevo usuario</a>
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
