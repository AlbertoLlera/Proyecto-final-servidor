@csrf

<div class="space-y-4">
    <div>
        <label for="comentario" class="block text-sm font-semibold text-gray-700">Comentario</label>
        <textarea name="comentario" id="comentario" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>{{ old('comentario', $comment->comentario ?? '') }}</textarea>
        @error('comentario')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="user_id" class="block text-sm font-semibold text-gray-700">Autor</label>
        @php($selectedUser = old('user_id', $comment->user_id ?? ''))
        <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
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

    <div>
        <label for="post_id" class="block text-sm font-semibold text-gray-700">Publicación</label>
        @php($selectedPost = old('post_id', $comment->post_id ?? ''))
        <select name="post_id" id="post_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            <option value="">Selecciona un post</option>
            @foreach ($posts as $postOption)
                <option value="{{ $postOption->id }}" @selected($selectedPost == $postOption->id)>
                    {{ $postOption->titulo }}
                </option>
            @endforeach
        </select>
        @error('post_id')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
