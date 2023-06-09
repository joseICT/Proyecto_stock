<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockNecesarioController extends Controller
{
    //verificar que esta logueado el usuario para poder ver la pagina
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Se lista toda la vista completa en los que sus meses y años sea igual al actual
    //actualizacion se modifico la vista y ahora entrega la media de ventas del año por producto
    //Se creo otra vista para evitar borrar la anterior
    public function list(){
        $datos=DB::table('Stock_critico_2')        
        ->get();
        $familia=DB::table('vv_tablas22') 
        ->get();
        $comentario=DB::table('comentario_stock_critico')
        ->get();
        return view('StockNecesario',compact('datos','familia','comentario'));
    }

    public function Search_ID($id){

        //no funciona todavia
        //$registro=DB::table('Stock_critico')->where('Codigo','=',$id)->get();
        //return redirect('StockNecesario')->with(compact('registro'));
        //return Redirect::back()->with('',compact('datos'));
    }

    //guardar y devolver registro de ventas de un determinado producto
    public function HistorialRegistro($id){
        $Consulta=DB::select(' SELECT 
        `dcargos`.`DECODI` AS `Codigo`,
        `producto`.`ARDESC` AS `Detalle`,
        `suma_bodega`.`cantidad` as `Bodega`,
        ceiling((SUM(`dcargos`.`DECANT`))/3) AS `Ventas_del_mes`,
        DATE_ADD(DATE_ADD(MAKEDATE(year(`dcargos`.`DEFECO`), 1), INTERVAL (month(`dcargos`.`DEFECO`))-1 MONTH), INTERVAL 0 DAY) AS `fecha`,
        MAX(media_productos.Media_de_ventas) AS Media_de_ventas
    FROM
        (((dcargos
        JOIN suma_bodega)
        JOIN producto)
        LEFT JOIN media_productos ON dcargos.DECODI = media_productos.Codigo)

    WHERE
        ((dcargos.DEFECO BETWEEN ((CURDATE() + INTERVAL (-(DAYOFMONTH(CURDATE())) + 1) DAY) - INTERVAL 23 MONTH) AND CURDATE())
            AND (dcargos.DECODI = suma_bodega.inarti)
            AND (dcargos.DECODI = producto.ARCODI)
            AND (dcargos.DETIPO <> 3)) and dcargos.DECODI="'.$id.'"
    GROUP BY dcargos.DECODI , YEAR(dcargos.DEFECO) , MONTH(dcargos.DEFECO)
    	order by Codigo,Fecha desc');

        return response()->json($Consulta);
    }

    public function IngrearComentario($ID,$Comentario){
        $Consulta2=DB::insert('INSERT INTO `comentario_stock_critico` (`Codigo`, `Comentario`) VALUES ('.$ID.', '.$Comentario.')');
    }
}
