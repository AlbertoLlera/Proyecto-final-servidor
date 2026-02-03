@csrf

<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700">Nombre completo</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
        @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="username" class="block text-sm font-semibold text-gray-700">Nombre de usuario</label>
        <input type="text" name="username" id="username" value="{{ old('username', $user->username ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
        @error('username')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
        @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="role" class="block text-sm font-semibold text-gray-700">Rol</label>
        <select name="role" id="role" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            @php($roleValue = old('role', $user->role ?? 'user'))
            <option value="user" @selected($roleValue === 'user')>Usuario</option>
            <option value="admin" @selected($roleValue === 'admin')>Administrador</option>
        </select>
        @error('role')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña @isset($user)<span class="font-normal text-gray-500">(dejar en blanco para mantener)</span>@endisset</label>
        <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-3 py-2" @isset($user) @else required @endisset>
        @error('password')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2" @isset($user) @else required @endisset>
    </div>
</div>
