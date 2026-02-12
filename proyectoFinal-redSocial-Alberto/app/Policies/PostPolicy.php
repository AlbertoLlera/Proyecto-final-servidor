<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determina si el usuario puede ver algún registro.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede ver este registro.
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede crear registros.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede actualizar este registro.
     */
    public function update(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Confirmamos que el usuario que creó la publicación es quien la gestiona o que es administrador.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->isAdmin();
    }

    /**
     * Determina si el usuario puede restaurar este registro.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede eliminar este registro de forma permanente.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
