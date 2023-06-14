<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockGuardadoController extends Controller
{
    public function list(){
        $datos=DB::table('Stock_critico_2')        
        ->get();
        $familia=DB::table('vv_tablas22') 
        ->get();
        $comentario=DB::table('comentario_stock_critico')
        ->get();
        $status=DB::table('producto_clasificar')
        ->get();
        return view('StockGuardado',compact('datos','familia','comentario','status'));
    }

    //actualizar varible para trasferir producto a stock guardado
    public function ActualizarVariable($id){
        $Consulta=DB::insert('INSERT INTO `producto_clasificar` (`Codigo`, `Estado`) VALUES ("'.$id.'", 2)');        
    }
}
