<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('user')->orderByDesc('created_at')->paginate(15);

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'users' => $this->userOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        $post = Post::create($data);

        return redirect()->route('admin.posts.edit', $post)
            ->with('status', 'Publicación creada.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'users' => $this->userOptions(),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validatePayload($request);
        $post->update($data);

        return redirect()->route('admin.posts.edit', $post)
            ->with('status', 'Publicación actualizada.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Publicación eliminada.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'imagen' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
        ]);
    }

    private function userOptions()
    {
        return User::orderBy('name')->get(['id', 'name', 'username']);
    }
}
