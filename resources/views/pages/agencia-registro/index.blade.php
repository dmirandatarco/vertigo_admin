@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h4 class="mb-3">Listado Registro de Agencia</h4>
          <div class="mb-5">
          </div>
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ $message }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            </div>
          @endif
          <div class="table-responsive">
            <table id="proveedors" class="table">
              <thead>
                <tr >
                  <th>Nº</th>
                  <th>Nombre</th>
                  <th>Documento</th>
                  <th>Numero</th>
                  <th>Celular</th>
                  <th>Correo</th>
                  <th>Documento</th>
                  <th>Estado</th>
                  <th>Confirmar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($agencias as $agencia)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$agencia->nombre}}</td>
                  <td>{{$agencia->documento}}</td>
                  <td>{{$agencia->numero}}</td>
                  <td>{{$agencia->celular}}</td>
                  <td>{{$agencia->correo}}</td>
                  <td>
                    @if($agencia->archivo)
                      <a href="{{asset('storage/img/agencias/'.$agencia->archivo)}}" target="_blank" data-bs-toggle="tooltip" data-bs-title="Ver Archivo" class="btn btn-warning btn-icon">
                        <i data-feather="eye"></i>
                      </a>
                    @endif
                  </td>
                  <td>
                    @if($agencia->aceptado==1)
                      <button type="button" class="btn btn-success ">
                        Confirmado
                      </button>
                    @else
                      <button type="button" class="btn btn-danger">
                        Sin Confirmar
                      </button>
                    @endif
                  </td>
                  <td>
                    @if($agencia->aceptado==0)
                      <a href="{{route('agenciaRegistro.aceptar',$agencia->id)}}" data-bs-toggle="tooltip" data-bs-title="Confirmar" class="btn btn-success btn-icon">
                        <i data-feather="check"></i>
                      </a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')

@if(count($errors)>0)
  @if(old('tipoform')=="crear")
    <script>
        $(function() {
            $('#Agregar').modal('show');
            $('#spanTexto').text("Crear proveedor");
        });
    </script>
  @else
    <script>
      $(function() {
          $('#Agregar').modal('show');
          $('#spanTexto').text("Editar proveedor");
      });
    </script>
  @endif

@endif

<script>

$(document).ready(function() {
    $("#servicio_id").select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
})

function agregar(){
  $('#spanTexto').text("Crear proveedor");
  $('#tipoform').val("crear");
  $('#id_proveedor').val(null);
  $('#nombre').val(null);
  $('#celular').val(null);
  $('#direccion').val(null);
  $('#precio').val(null);
  $('#servicio_id').select2('destroy');
  $('#servicio_id').val(null).select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
  $('#Agregar').modal('show');
}

function editar(id,nombre,celular,direccion,precio,servicio){
  $('#Agregar').modal('show');
  $('#spanTexto').text("Editar proveedor");
  $('#tipoform').val("editar");
  $('#id_proveedor').val(id);
  $('#nombre').val(nombre);
  $('#celular').val(celular);
  $('#direccion').val(direccion);
  $('#servicio_id').select2('destroy');
  $('#servicio_id').val(servicio).select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
  $('#precio').val(precio);
}

var eliminar = document.getElementById('Eliminar');

eliminar.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget
  var id = button.getAttribute('data-id')
  var idModal = eliminar.querySelector('.id_proveedor_2')
  idModal.value = id;
});

$(function() {
  'use strict';

  $(function() {
    $('#proveedors').DataTable({
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "language": {
        "lengthMenu": "Mostrar  _MENU_  registros por paginas",
        "zeroRecords": "Nada encontrado - disculpa",
        "info": "Mostrando la página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles.",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate":{
          "next": "Siguiente",
          "previous": "Anterior",
        }
      },
      "columnDefs": [
        {
          targets: [6],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush
