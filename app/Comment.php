<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'Comments';

     // Relacion de muchos a uno ()
    public function user(){
        // se encargara de sacar el objeto de usuario cuyo id se relacione con este user_id
        return $this->belongsTo('App\User', 'user_id');
    }

    // Relacion de muchos a uno ()
    public function image(){
        return $this->belongsTo('App\Image', 'image_id');
    }
}
