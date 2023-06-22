<!--Agregar la dataTable e insertar los datos de una vista creada para mostrar productos vendidos a lo largo del año actual
y mostar porcentaje de ventas de cada produto  
Posbles datos a usar una vez conversado los requerimientos 
CODIGO - DESCIPCION - VENTAS ACTUALES - VENTAS_MES_Y_AÑO_PASADO - STOCK_ACTUAL - STOCK_RECOMENDABLE - AVISO DE REABASTECIMINETO DEL MES-->
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<?php $variable=0;
$boton=0;
$coincidente=0?>
<div >
    <div class="card-body">

<table  id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
<!-- SE agrego la media de ventas para mostrar solo los productos que en bodega sean menores a la media de venta  -->
<!-- Se relizaron cambios de texto y posicion solamente -->
        <thead>
            <tr>
                <th>Estado</th>
                <th>Codigo</th> 
                <th>Nombre </th>
                <th>Marca</th>
                <th>Familia</th>
                <th>ultima fecha </th>
                <th>Ventas del mes</th>
                <th>Media de ventas</th>
                <th>Bodega</th>
                <th>Comentar/Ventas/Transferir/Orden</th>                                                                                 
            </tr>
        </thead>
    <tbody>
<!-- el mayor cambio es aqui al revisar los datos de la vista anterior se observo que habian datos perdidos por lo que se uso otra vista y se agrgaron mas filtros para
poder mostrar solo los datos del ultimo registro de ventas del mes de cada producto que aun tenga stock en bodega y este debajo de la media de ventas del año del 
ultimo registro de ventas-->

<!-- 1 foreach de todos los productos -->
    @foreach($datos as $lista )
<!-- 2 foreach de los productos para stock guardado  FALLA-->    
    @foreach($estado as $Clasificacion)
    <!-- 3 if para ver si imprime la varible  o no -->
    @if(strtoupper($Clasificacion->Codigo) == strtoupper($lista->Codigo))
    <?php $coincidente=1?>  
    <!-- 3 -->
    @endif
    <!-- 2 -->
    @endforeach
<!-- 4 if si el codigo es distinto a la variable creada al principio de la vista  FALLLA imprime multiples veces hasta encontrar su codigo-->    
    @if(strtoupper($lista->Codigo) != $variable)
<!-- 5 if si la media de ventas * 1.2 son mayores e igual a la existencia a bodegas-->    
    @if($lista->Media_de_ventas*1.2 >= $lista->Bodega)
<!-- 6 foreach para las familias de productos-->    
    @if($coincidente!=1)
    @foreach($familia as $family)
<!-- 7 if si el codigo de de familia es igual al del foreach de familia-->    
    @if($lista->codigo_familia == $family->tarefe)
<!-- 8 if si la media de ventas es mayor a bodega-->  
    @if($lista->Media_de_ventas>=$lista->Bodega)
    <tr class="text-danger" id="{{$lista->Codigo}}">
        <td>Critico</td>
    @else
        <tr class="text-warning" id="{{$lista->Codigo}}">
        <td>Poca Cantidad</td>
    <!-- 8-->        
    @endif
        <td>{{strtoupper($lista->Codigo)}}</td>
        <td>{{$lista->Detalle}}</td>
        <td>{{$lista->Marca_producto}}</td>        
        <td>{{$family->taglos}}</td>
        <td>{{$lista->fecha}}</td>
        <td>{{$lista->Ventas_del_mes}}</td>
        <td>{{$lista->Media_de_ventas}}</td>
        <td>{{$lista->Bodega}}</td>
        <td>
        <button class="fa fa-comment text-primary border border-light"  onclick='IngresarComentario(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalComentar data-toggle="modal"></button>
        <button class="fa fa-list text-primary border border-light"  onclick='historial(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalVer data-toggle="modal"></button>
        <button class="fa fa-exchange text-primary border border-light"  onclick='ClasificarProducto(id)'  id="{{$lista->Codigo}}"></button>
        <button class="fa fa-external-link-square text-primary border border-light"  onclick='GenerarOrden(id,value)'  id="{{$lista->Codigo}}" value="{{$lista->Detalle}}"></button>
        </td>                  
        </tr>
    <?php $variable=$lista->Codigo;
    $coincidente=0?>  
    <!--7 -->  
    @endif
    <!-- 6-->
    @endforeach 
    @endif   
    @else
    <?php $variable=$lista->Codigo;
    $coincidente=0?>
    <!-- 5 -->
    @endif
    <!-- 4 -->
    @endif
    <!-- 1 -->
    @endforeach
    </tbody>
    <tfoot>
            <tr>
                <th>Estado</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Familia</th>
                <th>Fecha</th>
                <th>Ventas</th>
                <th>Media</th>
                <th>Bodega</th>
                <th>botones</th>
            </tr>
        </tfoot>  
</table>
</div>
</div>

<div class="modal fade" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloProducto'>
        
      </div>
      <div class="modal-body" id="ModalContenedor">
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
      <div class="modal-footer" id='ModalFooter'>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalComentar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloDescripcion'>

      </div>
      <div class="modal-body">
        <input class="form-control input-lg" type="text">
      </div>
      <div class="modal-footer" id="TituloComentario">
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
    $('#StockNecesario tfoot th').each(function(){
          $(this).html('<input type="text" style="width: 100% ; padding: 3px; box-sizing: border-box" placeholder="Buscar" />');
        });
        $('#StockNecesario').DataTable({
          initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },

        
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
      $("#ModalFooter button").remove();
      $("#TituloProducto").append("<h5>"+detail+"</h5>");
      $('#ModalFooter').append("<button type=button class='btn btn-primary' onclick=BorrarFiltro("+id+")>Reiniciar</button> <button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>")
      $.ajax({
          type:'GET',
          url:'/Registro/'+id,
          success:function(data){
            $('#StockModal').dataTable().fnClearTable();
            $('#StockModal').dataTable().fnDestroy();
            data.forEach(element =>{
                $("#Tablahistorial" ).append( "<tr><td>"+element.Ventas_del_mes+"</td> <td>"+element.fecha+"</td></tr>" );
                
            })
            $('#StockModal').DataTable();
        }
      })
      
    }

    function IngresarComentario(id,descripcion){
      $("#TituloDescripcion h5").remove();
      $("#TituloComentario button").remove();
      $("#TituloDescripcion").append("<h5 id="+id+">"+descripcion+"</h5>");
      $("#TituloDescripcion").append("<h5 class=invisible>"+id+"</h5>");
      $("#TituloComentario").append("<button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>");
      $("#TituloComentario").append("<button type=button class='btn btn-primary' onclick=CrearComentario() id="+id+">Guardar</button>");
    }

    function CrearComentario(id,Comentario){
      $.ajax({
        type:'POST',
        url:'/IngresarComentario/'+id,
        data:{Cod:"id",Coment:"Comentario"},
        success:function(datos){
          console.log(datos.promedio)
        },
        
      })
    }

    function ClasificarProducto(id){
      $('#'+id+' button').attr("disabled", true);
      $('#'+id+' td').addClass("table-success");
      $.ajax({
        type:'POST',
        url:'/TransferirA/'+id,
        data: {
          "_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){          
        },            
      })      
    }

    function GenerarOrden(id,value){
      $.ajax({
        type:'POST',
        url:'/GenerarOrden/'+id,
        data:{
          "_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){
        },
      })
      alert("REQUERIMIENTO CREADO PARA EL PRODUCTO: "+value);
    }
</script>
@endsection