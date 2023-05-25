<!-- SE CREO PERO AUN NO SE USA Y NO SE TIENE CALRO SI SE USARA O NO
  
@section('ModalHistorial')
<div class="modal fade" id="VistaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Historial de venta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th> 
                <th>Detalle</th> 
                <th>Ventas del mes</th>
                <th>Mes y Año</th>      
            </tr>
        </thead>
    <tbody>
    @foreach()
    @if($lista->Codigo=$registo->Codigo)
    <tr>
        <td>{{$registo->Codigo}}</td>
        <td>{{$registo->Detalle}}</td>
        <td>{{$registo->Ventas_del_mes}}</td>
        <td>{{$registo->Mes}} del {{$registo->Año}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
    </div>
   <script>
      $(document).ready(function(){
        $('button').click(function(){
            $.ajax({url:"select.php",
            method:'post',
      data:{emp_id:}
      success: function(result){
        $('#div1').html(result);
      }});
      $('#myModal').modal('show');
        })
      })
      </script> 
    </div>
  </div>
</div>

@endsection-->