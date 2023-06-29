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
        $estado=DB::table('producto_clasificar')
        ->get();
        return view('StockNecesario',compact('datos','familia','comentario','estado'));
    }

    
    //Solicitud del historial de ventas de detreminado producto a lo largo de 24 meses al presionar un boton
    public function HistorialRegistro($id){
        $Consulta=DB::select(' SELECT 
        `dcargos`.`DECODI` AS `Codigo`,
        `producto`.`ARDESC` AS `Detalle`,
        `suma_bodega`.`cantidad` as `Bodega`,
        SUM(`dcargos`.`DECANT`) AS `Ventas_del_mes`,
        DATE_ADD(DATE_ADD(MAKEDATE(year(`dcargos`.`DEFECO`), 1), INTERVAL (month(`dcargos`.`DEFECO`))-1 MONTH), INTERVAL 0 DAY) AS `fecha`
    FROM
        ((dcargos
        JOIN suma_bodega)
        JOIN producto)
    WHERE
        ((dcargos.DEFECO BETWEEN ((CURDATE() + INTERVAL (-(DAYOFMONTH(CURDATE())) + 1) DAY) - INTERVAL 23 MONTH) AND CURDATE())
            AND (dcargos.DECODI = suma_bodega.inarti)
            AND (dcargos.DECODI = producto.ARCODI)
            AND (dcargos.DETIPO <> 3)) and dcargos.DECODI="'.$id.'"
    GROUP BY dcargos.DECODI , YEAR(dcargos.DEFECO) , MONTH(dcargos.DEFECO)
    	order by Codigo,Fecha desc');

        return response()->json($Consulta);
    }

    //Funcion usado para enviar un determinado producto a la vista stock guardado al prsionar un boton
    public function CambiarVariable($Id){
        $Consulta=DB::insert('INSERT INTO `producto_clasificar` (`Codigo`, `Estado`) VALUES ("'.$Id.'","1")');

    }

    //funcion usado para realizar requerimiento de determinado producto al presionar un boton
    public function RealizarRequerimiento($Codigo){
        
        $Consulta=DB::table('producto')->where('ARCODI',$Codigo)->first();
        
        $Consul=DB::insert('INSERT INTO `requerimiento_compra` (`codigo`,`descripcion`,`marca`,`cantidad`,`depto`,`estado`,`observacion_interna`)
         VALUES ("'.$Codigo.'","'.$Consulta->ARDESC.'","'.$Consulta->ARMARCA.'","1","Stock Critico","INGRESADO","Stock Critico")');
    }
}
