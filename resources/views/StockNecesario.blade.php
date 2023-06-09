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
<?php $variable=0?>
<div class="crow d-flex justify-content-center">
    <div class="card-body">

<table  id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
<!-- SE agrego la media de ventas para mostrar solo los productos que en bodega sean menores a la media de venta  -->
<!-- Se relizaron cambios de texto y posicion solamente -->
        <thead>
            <tr>
                <th>Estado</th>
                <th>Codigo</th> 
                <th>Nombre del producto</th>
                <th>Marca del producto</th>
                <th>Familia del producto</th>
                <th>ultima fecha de venta registrada</th>
                <th>Ventas totales de ese mes</th>
                <th>Media de ventas</th>
                <th>Bodega</th>
                <th>Comentario</th>
                <th>Editar comentario</th> 
                <th>Historial de ventas</th>                                                                                  
            </tr>
        </thead>
    <tbody>
<!-- el mayor cambio es aqui al revisar los datos de la vista anterior se observo que habian datos perdidos por lo que se uso otra vista y se agrgaron mas filtros para
poder mostrar solo los datos del ultimo registro de ventas del mes de cada producto que aun tenga stock en bodega y este debajo de la media de ventas del año del 
ultimo registro de ventas-->

<!-- agregada en la tabla marca, familia del producto y ademas poder colocar comentario al producto(aun contruyendo) -->
    @foreach($datos as $lista )
    @if(strtoupper($lista->Codigo) != $variable)
    @if($lista->Media_de_ventas*1.2 >= $lista->Bodega)
    @foreach($familia as $family)
    @if($lista->codigo_familia == $family->tarefe)
    @if($lista->Media_de_ventas>=$lista->Bodega)
    <tr class="text-danger">
        <td>A</td>
        <td>{{strtoupper($lista->Codigo)}}</td>
        <td>{{$lista->Detalle}}</td>
        <td>{{$lista->Marca_producto}}</td>        
        <td>{{$family->taglos}}</td>
        <td>{{$lista->fecha}}</td>
        <td>{{$lista->Ventas_del_mes}}</td>
        <td>{{$lista->Media_de_ventas}}</td>
        <td>{{$lista->Bodega}}</td>
        @foreach($comentario as $coment)
        @if($coment->Codigo==$lista->Codigo)
        <td>{{$coment->Comentario}}</td>
        @else
        <td></td>
        @endif
        @endforeach
        <td>
            <button 
             class="btn btn-primary" onclick='IngresarID({{$lista->Codigo}})' data-target=#ModalComentar data-toggle="modal">Comentar</button>
        </td>
        <td>
            <button onclick='historial(id, value)' href="#"  id="{{$lista->Codigo}}" value="{{$lista->Detalle}}" data-toggle="modal"
             data-target=#ModalVer class="btn btn-success btn-block checkout-btn">Consultar</button>
        </td>                    
        </tr>
    @else
    <tr class="text-warning">
      <td>B</td>
        <td>{{strtoupper($lista->Codigo)}}</td>
        <td>{{$lista->Detalle}}</td>
        <td>{{$lista->Marca_producto}}</td>        
        <td>{{$family->taglos}}</td>
        <td>{{$lista->fecha}}</td>
        <td>{{$lista->Ventas_del_mes}}</td>
        <td>{{$lista->Media_de_ventas}}</td>
        <td>{{$lista->Bodega}}</td>
        @foreach($comentario as $coment)
        @if($coment->Codigo==$lista->Codigo)
        <td>{{$coment->Comentario}}</td>
        @else
        <td></td>
        @endif
        @endforeach
        <td>
            <button 
             class="btn btn-primary" data-target=#ModalComentar data-toggle="modal">Comentar</button>
        </td>
        <td>
        <button onclick='historial(id,value)' href="#"  id="{{$lista->Codigo}}" value="{{$lista->Detalle}}" data-toggle="modal"
             data-target=#ModalVer class="btn btn-success btn-block checkout-btn">Consultar</button>
        </td>            
        </tr>
    @endif
    <?php $variable=$lista->Codigo ?>    
    @endif
    @endforeach    
    @else
    <?php $variable=$lista->Codigo ?>
    @endif
    @endif
    
    @endforeach
    </tbody>   
</table>
</div>
</div>

<div class="modal fade" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloProducto'>
        
      </div>
      <div class="modal-body">
      <table id="StockModal" class="table table-striped table-bordered" style="width:100%">
      <thead>        
        <tr>
          <th>Ventas del mes</th>
          <th>Fecha</th>
        </tr>        
      </thead>
      <tbody id='Tablahistorial'>

      </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalComentar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id="TituloComentario">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
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

    function historial(id,detail){
      console.log(id);
      console.log(detail);
      $("#StockModal td").remove();
      $("#TituloProducto h5").remove();

      $("#TituloProducto").append("<h5>"+detail+"</h5>");
      $.ajax({
          type:'GET',
          url:'/Registro/'+id,
          success:function(data){
            
            data.forEach(element =>{
                $("#Tablahistorial" ).append( "<tr><td class=text-center>"+element.Ventas_del_mes+"</td> <td>"+element.fecha+"</td></tr> " );
                
            })
        }
      })
    }

    function IngresarID(id){
      $("#TituloComentario h5").remove();
      $('#TituloComentario').append("<h5 class=modal-title>"+id+"</h5>");
      console.log(id);
    }
</script>
@endsection