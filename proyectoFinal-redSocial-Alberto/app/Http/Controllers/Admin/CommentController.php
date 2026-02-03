<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(): View
    {
        $comments = Comentario::with(['user', 'post'])->orderByDesc('created_at')->paginate(20);

        return view('admin.comments.index', [
            'comments' => $comments,
        ]);
    }

    public function create(): View
    {
        return view('admin.comments.create', [
            'users' => $this->userOptions(),
            'posts' => $this->postOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);
        $comment = Comentario::create($data);

        return redirect()->route('admin.comments.edit', $comment)
            ->with('status', 'Comentario creado.');
    }

    public function edit(Comentario $comment): View
    {
        return view('admin.comments.edit', [
            'comment' => $comment->load(['user', 'post']),
            'users' => $this->userOptions(),
            'posts' => $this->postOptions(),
        ]);
    }

    public function update(Request $request, Comentario $comment): RedirectResponse
    {
        $data = $this->validatePayload($request);
        $comment->update($data);

        return redirect()->route('admin.comments.edit', $comment)
            ->with('status', 'Comentario actualizado.');
    }

    public function destroy(Comentario $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('status', 'Comentario eliminado.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'comentario' => ['required', 'string', 'max:500'],
            'user_id' => ['required', 'exists:users,id'],
            'post_id' => ['required', 'exists:posts,id'],
        ]);
    }

    private function userOptions(): Collection
    {
        return User::orderBy('name')->get(['id', 'name', 'username']);
    }

    private function postOptions(): Collection
    {
        return Post::orderByDesc('created_at')->get(['id', 'titulo']);
    }
}
