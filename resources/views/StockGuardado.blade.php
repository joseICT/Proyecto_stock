<!-- Es una copia de la vista stock necesario para replicar y mostrar los productos que se transfieran y viceversa-->

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
                <th>Comentar/Ventas/Transferir</th>                                                                                 
            </tr>
        </thead>
    <tbody>
    @foreach($status as $listado)
    @if(($listado->Estado)==1) 
    @foreach($datos as $lista)
    @if(strtoupper($lista->Codigo) != $variable && ($listado->Codigo)==($lista->Codigo))
    @if($lista->Media_de_ventas*1.2 >= $lista->Bodega)
    @foreach($familia as $family)
    @if($lista->codigo_familia == $family->tarefe)
    @if($lista->Media_de_ventas>=$lista->Bodega)
    <tr class="text-danger">
        <td>Critico</td>
    @else
        <tr class="text-warning">
        <td>Cercano critico</td>
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
        <button onclick='IngresarComentario(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalComentar data-toggle="modal"></button>
        <button onclick='historial(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalVer data-toggle="modal"></button>
        <button onclick='CambiarVariable(id)' id="{{$lista->Codigo}}"></button>
        <!-- <i class="fas fa-comment" onclick='IngresarComentario(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalComentar data-toggle="modal"></i>
        <i class="fas fa-list" onclick='historial(id,value)' value="{{$lista->Detalle}}" id="{{$lista->Codigo}}" data-target=#ModalComentar data-toggle="modal"></i>
        <i class="fas fa-exchange"></i> -->
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

    function IngresarComentario(id,descripcion){
      $("#TituloDescripcion h5").remove();
      $("#TituloComentario button").remove();
      $("#TituloDescripcion").append("<h5 id="+id+">"+descripcion+"</h5>");
      $("#TituloDescripcion").append("<h5 class=invisible>"+id+"</h5>");
      $("#TituloComentario").append("<button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>");
      $("#TituloComentario").append("<button type=button class='btn btn-primary' onclick=CrearComentario() id="+id+">Guardar</button>");
    }

    function CambiarVariable(id){
        $.ajax({
            type:'POST',
            url:'/TransferirB/'+id,
            data:{ID:"id"},
            success:function(datos){
                console.log(datos.promedio)
            },
        })
    }
</script>
@endsection