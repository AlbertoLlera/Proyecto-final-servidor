<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'imagen', 'user_id'];

    //Crearemo una relación inversa porque los posts pertenecen a un usuario
    public function user(){
        //Le especificamos exactamente la información que queremos traer del usuario, que no es toda
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    /*
    Como tenemos una relación de uno a muchos, utilizamos el hasMany para traer los comentarios de cada post 
    */
    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user){
        return $this->likes->contains('user_id', $user->id);
    }
}