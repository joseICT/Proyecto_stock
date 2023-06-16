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
    public function BorrarVariable($Id){
        $Consulta=DB::delete('DELETE FROM `producto_clasificar` WHERE `Codigo`="'.$Id.'"');
        return response()->json(['status'=>'ok']);
    }

    //crear o actualizar comentario
    public function EscribirComentario($Id,$COMENT){
        if(comentario_stock_critico::where('Codigo',$Id)->exist()){
            $Consulta=DB::update('UPDATE * FROM `comentario_stock_critico` SET `Codigo` = "'.$ID.'", `Comentario`="'.$COMENT.'"');
        }else{
            $Consulta=DB::insert('INSERT * FROM `comentario_stock_critico` (`Codigo`,`Comentario`) VALUES ("'.$Id.'","'.$COMENT.'")');
        }
    }
}
