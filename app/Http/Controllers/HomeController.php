<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Image; //para listar las imagenes en el home

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // para la paginacion usaremos paginate y 5 elementos por pagina  solo me apareceran 5 cartas en home y si en la url agregamos ?page=2 solo seran dos paginas
        $images = Image::orderBy('id', 'desc')->paginate(5); //litado de todas las img de la BDpuedes usar all
        return view('home',[
            'images' => $images
        ]);
    }
}
