<!-- Es una copia de la vista stock necesario para replicar y mostrar los productos que se transfieran y viceversa-->

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<?php $variable=0?>
<div>
    <div class="card-body">

<table  id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Codigo</th> 
                <th>Nombre </th>
                <th>Marca</th>
                <th>Familia</th>
                <th>ultima venta registrada</th>
                <th>Media de ventas</th>
                <th>Bodega</th>
                <th>Comentar/Ventas/Transferir/Orden</th>                                                                                 
            </tr>
        </thead>
    <tbody>
      <!-- filtrado de informacion a desplegar en la tabla primero el imprimir la informacion solo delos 
      productos que existan en la tabla producto clasificar y el resto sigue la misma logica que la de stock necesario-->
    @foreach($status as $listado)
    @if(($listado->Estado)==1) 
    @foreach($datos as $lista)
    @if(strtoupper($lista->Codigo) != $variable && ($listado->Codigo)==($lista->Codigo))
    @if($lista->Media_de_ventas*1.2 >= $lista->Bodega)
    @foreach($familia as $family)
    @if($lista->codigo_familia == $family->tarefe)
    @if($lista->Media_de_ventas>=$lista->Bodega)
    <tr class="text-danger" id="{{$lista->Codigo}}">
        <td>Critico</td>
    @else
        <tr class="text-warning" id="{{$lista->Codigo}}">
        <td>Cercano critico</td>
    @endif
        <td>{{strtoupper($lista->Codigo)}}</td>
        <td>{{$lista->Detalle}}</td>
        <td>{{$lista->Marca_producto}}</td>        
        <td>{{$family->taglos}}</td>
        <td>{{$lista->fecha}}</td>
        <td>{{$lista->Media_de_ventas}}</td>
        <td>{{$lista->Bodega}}</td>
        <td>
        <button class="fa fa-comment text-primary border border-light"  onclick='IngresarComentario(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalComentar data-toggle="modal"></button>
        <button class="fa fa-list text-primary border border-light"  onclick='historial(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalVer data-toggle="modal"></button>
        <button class="fa fa-exchange text-primary border border-light"  onclick='CambiarVariable(id)'  id="{{$lista->Codigo}}"></button>
        <button class="fa fa-external-link-square text-primary border border-light"  onclick='GenerarOrden(id,value)'  id="{{$lista->Codigo}}" value="{{$lista->Detalle}}"></button>
        </td>                  
        </tr>
    <?php $variable=$lista->Codigo ?>    
    @endif
    @endforeach    
    @else
    <?php $variable=$lista->Codigo ?>
    @endif
    @endif
    
    @endforeach
    @endif
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
                <th>Media</th>
                <th>Bodega</th>
                <th>botones</th>
            </tr>
        </tfoot>  
</table>
</div>
</div>

<!-- Modal de historial de ventas  -->
<div class="modal fade" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloProducto'>
        
      </div>
      <div class="modal-body" id="ModalContenedor">
        <div style= "width:55%; float:left; padding: 5px">
          <table id="StockModal" class="table table-striped table-bordered " >
      <thead>        
        <tr >
          <th></th>
          <th style="width:58%">Fecha</th>
          <th>Ventas del mes</th>          
        </tr>        
      </thead>
      <tbody id='Tablahistorial'>

      </tbody>
      </table>
        </div>

        <div style= "width:45%; float:left; padding: 5px">
        <table id="StockModal2" class="table table-striped table-bordered" >
      <thead>        
        <tr>
          <th style="width:56%">Fecha</th>
          <th>Ventas del mes</th>          
        </tr>        
      </thead>
      <tbody id='Tablahistorial2'>

      </tbody>
      </table>
        </div>
      </div>
      <div class="modal-footer" id='ModalFooter'>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal de Comentarios de producto (no cumple ninguna funcion) -->
<div class="modal fade" id="ModalComentar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloDescripcion'>
        
      </div>
      <div class="modal-body" id="CuerpoModal">
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

//funcion que se ejecuta al iniciar la pagina
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
              {
      extend: 'excelHtml5',
      title: 'Stock Guardado',
      text: "Excel",
      exportOptions: {
        columns: [0, 1,2,3,4,5,6,7] 
    }
  },{
    extend: 'pdfHtml5',
    title: 'Stock Guardado',
    text: "Pdf",
    exportOptions: {
        columns: [0, 1,2,3,4,5,6,7] 
    }
}
        ]
        });
        $('#StockNecesario tfoot tr').appendTo('#StockNecesario thead');
        $('#StockNecesario_filter label').remove();
    });

    //Funcion para desplegar toda la informacion de ventas de cada mes de determinado producto
    function historial(id,detail){     
      $("#StockModal td").remove();
      $("#TituloProducto h5").remove();
      $("#ModalFooter button").remove();
      $("#TituloProducto").append("<h5>"+detail+"</h5>");
      $('#ModalFooter').append("<button class='btn btn-primary' onclick=BorrarFiltro('"+id+"')>Reiniciar</button> <button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>")
      $.ajax({
          type:'GET',
          url:'/Registro/'+id,
          success:function(data){
            $('#StockModal').dataTable().fnClearTable();
            $('#StockModal').dataTable().fnDestroy();
            data.forEach(element =>{
                $("#Tablahistorial" ).append( "<tr id='"+element.fecha+"'><td><button id='"+element.fecha+"' onclick=clasificarVenta('"+element.Codigo+"',"+element.Ventas_del_mes+",'"+element.fecha+"')></button></td><td>"+element.fecha+"</td> <td>"+element.Ventas_del_mes+"</td> </tr>" );                
            })
            $('#StockModal').DataTable({
              searching: false,
              dom: 'Bfrtip',
            buttons: [
                
        ]
            });
           
        }        
      })
      
      $.ajax({
        type:'GET',
          url:'/RegistroB/'+id,
          success:function(data){
            $('#StockModal2').dataTable().fnClearTable();
            $('#StockModal2').dataTable().fnDestroy();
            data.forEach(element =>{
                $("#Tablahistorial2" ).append("<tr id='"+element.Fecha+"'><td>"+element.Fecha+"</td> <td>"+element.Venta+"</td> </tr>" );
            })
            $('#StockModal2').DataTable({              
              searching: false,
              dom: 'Bfrtip',
              buttons: [
        ]
            });
          }
          
      })
    }

    //funcion para depslegar los contenidos del modal comentario(no cumple ninguna funcion)
    function IngresarComentario(id,descripcion){
      $("#TituloDescripcion h5").remove();
      $("#TituloComentario button").remove();
      $("#TituloDescripcion").append("<h5 id="+id+">"+descripcion+"</h5>");
      $("#TituloDescripcion").append("<h5 class=invisible>"+id+"</h5>");
      $("#TituloComentario").append("<button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>");
      $("#TituloComentario").append("<button type=button class='btn btn-primary' onclick=CrearComentario(id) id="+id+">Guardar</button>");
    }

    //funcion para enviar determinado producto a la vista stock necesario
    function CambiarVariable(id){
      $('#'+id+' button').attr("disabled", true);
      $('#'+id+' td').addClass("table-success");
      $.ajax({
        type:'DELETE',
        url:'/TransferirB/'+id,
        data: {
        "_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){
          
        },
            
      })
      
    }

    //funcion para crear comentario(no funciona)
    function CrearComentario(id){
      $.ajax({
        type:'POST',
        url:'/IngresarComentario/'+id,
        data:{Cod:"id","_token": $("meta[name='csrf-token']").attr("content")},
        success:function(datos){
          alert('todo salio bien')
        },
        
      })
    }

    //funcion para la interaccion entre las dos tablas de historial de ventas
    function clasificarVenta(id,ventas,fecha){
      $('#'+fecha+' button').attr("disabled", true);
      $("#Tablahistorial tr#"+fecha).addClass("table-success");
      $("#Tablahistorial2" ).append( "<tr><td>"+fecha+"</td> <td>"+ventas+"</td> </tr>" );
      $.ajax({
        type:'POST',
        url:'/ClasificarVenta',
        data: {
         "Codigo":id, "venta":ventas,"fecha":fecha,"_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){ 
          console.log(datos);
        },
        
      })
    }

    //funcion para realizar un requerimiento de determinado producto
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

    function BorrarFiltro(id){
      $("#Tablahistorial2 tr").remove();
      $.ajax({
        type:'DELETE',
        url:'/eliminartabla/'+id,
        data: {
        "_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){
          alert('tabla restablecida')
        },
      })
    }
</script> 
@endsection