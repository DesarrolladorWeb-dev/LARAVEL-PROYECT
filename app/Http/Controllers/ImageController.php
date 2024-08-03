<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function create(){
        return view('image.create');
    }
    public function save(Request $request){

                // Validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            // formatos que permite mimes 
            // 'image_path' => 'required|mimes:jpg,jpeg,png,gif'
            'image_path' => 'required|image'
        ]);

        // Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');
      
        // Asignar valores nuevo objeto 
        // la barra es para que coja el namespace por defecto de esa clase es como una clase como general
        $user = \Auth::user();  //seteamos el objeto usuario actual 
        $image = new Image(); 
        $image->user_id = $user->id;
        $image->description = $description;

        var_dump($user->id);
        

        // Subir Fichero 
        if($image_path){

            // Nombre del archivo
            $image_path_name = time().$image_path->getClientOriginalName();

            // Se guarda el archivo 
            Storage::disk('images')->put($image_path_name,File::get($image_path));

            //el nombre se guarda en la base de datos
            $image->image_path = $image_path_name;
        } 

        $image->save();

        return  redirect()->route('home')->with([
            'message' => 'La foto a sido subida correctamente'
        ]);
        
    }

    public function getImage ($filename){
        // veremos todas las imagenes  por usuario
        // //obtendremos las imagenes que se llaman como lo enviamos desde home.blade 
        $file = Storage::disk('images')->get($filename); 
        return new Response($file,200);
    }

    public function detail($id){
        // la id de la imagen que quiero sacar
        $image = Image::find($id);

        return view('image.detail',[
             'image' => $image   

        ]);
    }

    public function delete($id){
        $user =   \Auth::user();
        $image = Image::find($id);
        // No puedo borrar la imagen porque tiene registros asociados 
        // entonces debo borrar registro comentarios antes:
        
        // Con esto sacamos todos los campentario con el id que le pasamos por url
        $comments = Comment::where('image_id', $id)->get(); 
        $likes = Like::where('image_id',$id)->get();

        if($user && $image && $image->user->id == $user->id ){
            // Eliminar comentarios
                if($comments && count($comments) >= 1){
                    foreach ($comments as $comment) {
                        $comment->delete();
                    }
                }
            // Elimnar los likes
                if($likes && count($likes) >= 1){
                    foreach ($likes as $like) {
                        $like->delete();  //borramos cada uno de los likes 
                    }
                }
            //  Eliminar ficheros de Imagen
                // Eliminar del storage - imagenes fisicos image_path nombre 
                Storage::disk('images')->delete($image->image_path);

            // Eliminar registro imagen 
            $image->delete();
            $message = array("message" => 'ha borrado correctamente');
            
        }else{
            $message = array("message" => 'La imagen no se ha borrado correctamente');
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($id){ //id de la imagen a actualizar
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){

            return view('image.edit',[
                'image' => $image
            ]);
        }else{
           return redirect()->route('home'); 
        }
    }

    public function update(Request $request){
        // Validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            // formatos que permite mimes 
            // 'image_path' => 'required|mimes:jpg,jpeg,png,gif'
            'image_path' => 'image'
        ]);

        // Recoger datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path'); //aqui me guardara lo que es la image
        $description = $request->input('description');

        // Conseguir el objeto image
        $image = Image::find($image_id);
        $image->description = $description;


        // Subir Fichero 
        if($image_path){

            // Nombre del archivo
            $image_path_name = time().$image_path->getClientOriginalName();

            // Se guarda el archivo 
            Storage::disk('images')->put($image_path_name,File::get($image_path));

            //el nombre se guarda en la base de datos
            $image->image_path = $image_path_name;
        } 
        // Actualizar Registro
        $image->update();

        return redirect()->route('image.detail',['id' => $image_id])
                    ->with(['message' => 'Imagen actualizada con exito']);

    }


}
