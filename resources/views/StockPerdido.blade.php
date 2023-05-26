<!-- Vista que devuelve los productos que ya no se en cuentran en inventario, esto fue credo debido a como se comporta la tabla
de inventario con los productos que llegan a 0, son borrados de la misma tabla  -->

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container mt-5">
    <div class="card-body">

<table id="StockPerdido" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th> 
                <th>Detalle</th>
                <th>Mes</th>
                <th>ventas del mes</th>       
            </tr>
        </thead>
    <tbody>
    @foreach($datos as $lista )
    <tr>
        <td>{{$lista->Codigo}}</td>
        <td>{{$lista->Descripcion}}</td>
        <td>{{ date("F", mktime(0, 0, 0, $lista->Mes, 1)) }}</td>
        <td>{{$lista->Ventas_del_mes}}</td>
    </tr>
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
    $('#StockPerdido').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
    });
});
</script>
@endsection