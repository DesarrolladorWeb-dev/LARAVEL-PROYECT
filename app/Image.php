<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	// la tabla que va a modificar el modelo
    protected $table = 'images';

    // Relacion de uno a muchos a los Comments
    public function comments(){
    	// Con que objeto quiero que se relacione
    	return $this->hasMany('App\Comment')->orderBy('id','desc');  //tendre una array

    }

    // Relacion de uno a muchos a los Likes
    public function likes(){
    	return $this->hasMany('App\Like');
    }
    // Relacion de muchos a uno (imagenes de un usuario)
    public function user(){
    	// belongsTo saca el objeto que necesite 
    	// usar el user_id porque es el campo que tengo en mi tabla image
    	// y lo relaciono con el otro objeto App/User
    	return $this->belongsTo('App\User', 'user_id');
    }
}
