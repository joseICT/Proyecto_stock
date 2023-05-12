<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockNecesarioController extends Controller
{
    //verificar que esta logueado el usuario para poder ver la pagina
    public function __construct()
    {
        $this->middleware('auth');
    }
    //la funcion para listar todos los datos necesarios de la vista de base de datos
    public function list(){        
        $data=DB::table('productos_porcentaje')->get();
        return view('StockNecesario',compact('data'));

    }
}
