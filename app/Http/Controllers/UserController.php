<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{
    // Autenticar a nivel de ruta - primero mirar que este autenticado para 
    // poder ingresar a esta ruta 
      public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search = null) {

        if(!empty($search)){
            // en la url /pa  i nos mostrara paco
            $users = User::where('nick', 'LIKE' ,'%'.$search.'%')
            // orWhere : o si se cumple esta condicion
                                  ->orWhere('name','LIKE','%'.$search.'%')
                                  ->orWhere('surname','LIKE','%'.$search.'%')
                                  ->orderBy('id', 'desc')
                                  ->paginate(5);
        }else{
           $users = User::orderBy('id', 'desc')->paginate(5);
        }


        return view('user.index',[
            'users' => $users
        ]);

    }
    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        // Conseguir Usuario Identificado 
        $user = \Auth::user(); // para acceder al objeto usamos la barra adelante - por si falla
        $id = $user->id; //del usuario actual obtendremos el id 

        // Validacion del Formulario
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            // que no exista ningun otro usuario que tenga el mismo nick en la tabla de usuario
            // pero habra una excepcion de que este nick de este usuario que tiene este $id puede ser igual  
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id, //que sea unico en la tabla de usuario
        ]);

        // Recoger datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        // Subir la imagen 
        $image_path = $request->file('image_path');
        if($image_path){
            // poner nobre unico
            $image_path_name = time().$image_path->getClientOriginalName(); 
            var_dump($image_path_name);

            $user->image = $image_path_name;

            // Guardarlo en la Carpeta
            // param 1 : nombreOriginal    , param 2 : el archivo completo  
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // Seteo el nombre de la imagen en el objeto 
        }

        //Ejecutar Consulta y cambios en la base de datos 
        $user->update();

        return redirect()->route('config')
                        ->with(['message'=>'Actualizado Correctamente']);

    }

    public function getImage($filename){
        // sacamos la imagen
        $file = Storage::disk('users')->get($filename);
        // Devuelvo 200 para imprimirlo en pantalla 
        return new Response($file, 200);
    }

    public function profile($id){
        $user = User::find($id);

        return view('user.profile',[
            'user' => $user
        ]);
    }

}
