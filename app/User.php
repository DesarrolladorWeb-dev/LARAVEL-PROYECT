<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role','name','surname','nick', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // al crear el usuario quiero listar todas las imagenes que ha creado
    

    // Relacion de uno a muchos a los Comments
    public function images(){
        // Con que objeto quiero que se relacione
        return $this->hasMany('App\Image');  //tendre una array

    }
}
