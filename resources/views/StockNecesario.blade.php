<!--Agregar la dataTable e insertar los datos de una vista creada para mostrar productos vendidos a lo largo del año actual
y mostar porcentaje de ventas de cada produto  
Posbles datos a usar una vez conversado los requerimientos 
CODIGO - DESCIPCION - VENTAS ACTUALES - VENTAS_MES_Y_AÑO_PASADO - STOCK_ACTUAL - STOCK_RECOMENDABLE - AVISO DE REABASTECIMINETO DEL MES-->
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container mt-5">
    <div class="card-body">

<table id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
<!-- SE agrego la media de ventas para mostrar solo los productos que en bodega sean menores a la media de venta  -->
        <thead>
            <tr>
                <th>Codigo</th> 
                <th>Detalle</th>
                <th>Fecha</th>
                <th>Stock en bodega</th> 
                <th>Ventas del mes</th>
                <th>Media de ventas</th>                
                <th>Historial</th>         
            </tr>
        </thead>
    <tbody>
    @foreach($datos as $lista )
    @if($lista->Media_de_ventas > $lista->Bodega)
    <tr>
        <td>{{$lista->Codigo}}</td>
        <td>{{$lista->Detalle}}</td>
        <td>{{$lista->Mes}} del {{$lista->Año}}</td>
        <td>{{$lista->Bodega}}</td>
        <td>{{$lista->Ventas_del_mes}}</td>
        <td>{{$lista->Media_de_ventas}}</td>       
        <td><a data-toogle="modal" data-target="#VistaModal" class="btn btn-success btn-block checkout-btn">Consultar</a>
        </td>
    </tr>
    @endif
    <!--@yield('ModalHistorial')-->
    @endforeach
    </tbody>

</table>
</div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>


<script>  
// ejecutar un scrip que agrega distintas herramientas a la tabla de datos  
    $(document).ready(function () {
    $.noConflict();
    $('#StockNecesario').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
    });
});
</script>
@endsection