<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockPerdidoController extends Controller
{
    //verificar que esta logueado el usuario para poder ver la pagina
    public function __construct()
    {
        $this->middleware('auth');
    }
    //la vista para mostrar el stock que no se encuentra en inventario pero se sigue vendiendo en los ultimos 2 meses
    public function list(){
        $datos=DB::table('ventas_sin_inventario')
        ->get();
        return view('StockPerdido',compact('datos'));
        
    }
}
