@csrf

<div class="space-y-4">
    <div>
        <label for="titulo" class="block text-sm font-semibold text-gray-700">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $post->titulo ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
        @error('titulo')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="descripcion" class="block text-sm font-semibold text-gray-700">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>{{ old('descripcion', $post->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="imagen" class="block text-sm font-semibold text-gray-700">Ruta de imagen</label>
        <input type="text" name="imagen" id="imagen" value="{{ old('imagen', $post->imagen ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
        @error('imagen')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="user_id" class="block text-sm font-semibold text-gray-700">Autor</label>
        <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            @php($selectedUser = old('user_id', $post->user_id ?? ''))
            <option value="">Selecciona un usuario</option>
            @foreach ($users as $userOption)
                <option value="{{ $userOption->id }}" @selected($selectedUser == $userOption->id)>
                    {{ $userOption->name }} ({{ $userOption->username }})
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
