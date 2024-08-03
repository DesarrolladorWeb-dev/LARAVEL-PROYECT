<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;


class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){ 
        $user = \Auth::user();
        // Nos sacaran todos los likes
        $likes = Like::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->paginate(5);

        return view('like.index',[
            'likes' => $likes
        ]); 
    }

    public function like($image_id){
        // Recoger datos del usuario y la imagen 
        $user = \Auth::user();

        // Condicion para ver si ya existe el like y no duplicarlo
        $isset_like = Like::where('user_id',$user->id)
                            ->where('image_id',$image_id)
                            ->count();  //para saber que resultados obtengo


        if ($isset_like == 0) {
            
            
            $like = new Like();
            $like->user_id = $user->id;
            // Convertir a entero
            $like->image_id = (int)$image_id;

            // Guardar 
            $like->save();
     
            return response()->json([
                'like' => $like
            ]);

        }else{
            return response()->json([
                'message' => 'El Like Ya Existe'
            ]);
        }

    }
    public function dislike($image_id){
        // Recoger datos del usuario y la imagen 
        $user = \Auth::user();

        // Condicion para ver si ya existe el like y no duplicarlo
        $like = Like::where('user_id',$user->id)
                             ->where('image_id',$image_id)
                            ->first(); //me permite sacar un unico objeto


        if ($like) {
            
            // Eliminar Like
            $like->delete();

     
            return response()->json([
                'like' => $like,
                'message' => 'Dislike Correctamente'
            ]);

        }else{
            return response()->json([
                'message' => 'El Like  no Existe'
            ]);
        }

    }

 

}
