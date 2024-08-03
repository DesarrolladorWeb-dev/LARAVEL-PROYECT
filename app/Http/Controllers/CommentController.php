<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;


class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){
        
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);
        // Recoger Datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Asigno los valore a mi nuevo Objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        // Guardar en la bd
        $comment->save();

        // Redireccion 
        return redirect()->route('image.detail',['id' => $image_id])
                            ->with([
                                'message' => 'Has publicado tu commentario correctamente!!'
                            ]);
    }

    public function delete($id){
        //Conseguir datos del usuario identificado 
        $user = \Auth::user();  //obtengo el usuario que tiene la session

        //Conseguir el objeto del comentario
        $comment = Comment::find($id);
        var_dump($id);

        // Comprobar si soy el dueño del comentario o de la publicacion 
        // si el user_id de la imagen es igual al id del usuario actual y lo mismo con el 
        // comentario
        
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            $comment->delete();

            return redirect()->route('image.detail',['id' => $comment->image->id])
                    ->with([
                        'message' => 'Comentario eliminado Correctamente!!'
                    ]);
        }else{


            return redirect()->route('image.detail',['id' => $comment->image->id])
                    ->with([
                        'message' => 'Comentario no Eliminado'
                    ]);   

        }
     }
}
