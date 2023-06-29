<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
//Controlador de los productos archivados que no quiera ver en stock Necesario
class StockGuardadoController extends Controller
{
    //Todas las listas necesarias para desplegar en la vista
    //-La lista de todos los productos cons sus ventas mensuales a lo largo de 24 meses atras
    //-La familia del producto
    //-La tabla donde almacenar comentarios de cada producto(No probado, por lo que no puedo asegurar que sea funcional)
    //-Tabla donde ocupado para determinar si el producto se desplegara en stock necesario o stock guardado
    public function list(){
        $datos=DB::table('Stock_critico_2')        
        ->get();
        $familia=DB::table('vv_tablas22') 
        ->get();
        $comentario=DB::table('comentario_stock_critico')
        ->get();
        $status=DB::table('producto_clasificar')
        ->get();
        $listado=DB::table('ventas_clasificar')
        ->get();
        return view('StockGuardado',compact('datos','familia','comentario','status','listado'));
    }

    //funcion usada para regresar el producto seleccionado a stock necesario
    public function BorrarVariable($Id){
        $Consulta=DB::delete('DELETE FROM `producto_clasificar` WHERE `Codigo`="'.$Id.'"');
        return response()->json(['status'=>'ok']);
    }

    //crear o actualizar comentario (no funcional)
    public function EscribirComentario($Id,$com){
        $Consulta=DB::insert('INSERT * FROM `comentario_stock_critico` (`Codigo`,`Comentario`) VALUES ("'.$Id.'","'.$com.'")');
    }

    //interaccion de listado de tablas de ventas
    public function CambiarVentaMes(Request $request){
        $Consulta=DB::table('ventas_clasificar')->insert([
            "Codigo"=>$request->get("Codigo"),
            "Venta"=>$request->get("venta"),
            "Fecha"=>$request->get("fecha")
        ]);
        return response()->json(['status'=>'ok']);
    }
}
