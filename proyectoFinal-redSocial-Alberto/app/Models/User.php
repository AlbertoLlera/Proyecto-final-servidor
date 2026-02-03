<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //Vamos a crear un metodo que defina la relación entre usuario y posts
    public function posts(){
        //La relación es uno a muchos
        return $this->hasMany(Post::class);
    }

    //Funcion para grestionar los likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //Metodo que almacena los seguidores de un usuario
    public function followers(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //Comprobar que un usuario siga a otro
    public function siguiendo(User $user){
        return $this->followers->contains($user->id);
    }

    //Metodo que almacena los usuarios a los que un usuario sigue
    public function following(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

}
