@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper">
    <div class="col-md-12">
        <div class="card">
        <div class="card-body">
            <div class="row">
            <h4 class="mb-3">Listado de nosotros</h4>
            <div class="mb-5">
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table id="reservas" class="table">
                <thead>
                    <tr >

                        <th>NOMBRE</th>
                        <th>USUARIO</th>
                        <th>Idioma</th>
                            @foreach($languages2 as $lanaguage)
                                <th>{{$lanaguage->abreviatura}}</th>
                            @endforeach
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($nosotros as $i => $nosotro)
                    <tr>
                        <td> {{$nosotro->id}}</td>
                        <td> {{$nosotro->user->nombre}} {{$nosotro->user->apellido}}</td>
                        <td><img style="width:25px;" src="{{$nosotro->language?->icono}}" alt="{{$nosotro->language?->icono}}"></td>
                        @foreach($languages2 as $language)
                            <td>
                            @php
                                $translation = $nosotro->traducciones->firstWhere('language_id', $language->id);
                                $inverseTranslation = $nosotro->traduccionesinversas->firstWhere('language_id', $language->id);
                                $inverseTranslationespanol = $nosotro->traduccionesinversas->firstWhere('language_id', 1);
                                $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $nosotro->language_id == $language->id) ? $inverseTranslationespanol : null ));
                            @endphp
                            @if($selectedTranslation)
                                <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->titulo}}">
                                    <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                                </a>
                            @else
                                <a href="{{ route('nosotros.traducir',['lang'=>$language->id,'nosotros'=>$nosotro]) }}">
                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                </a>
                            @endif
                            </td>
                        @endforeach
                        <td>

                            <a href="{{ route('nosotros.edit',$nosotro->id) }}">
                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" >
                                    <i data-feather="edit"></i>
                                </button>
                            </a>
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


    <div class="modal fade" id="Eliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Estado </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('nosotros.destroy','test')}}" method="POST" autocomplete="off">
                        {{method_field('delete')}}
                        {{csrf_field()}}
                        <p>Estas seguro de cambiar el estado?</p>
                        <div class="modal-footer">
                            <input type="hidden" name="id_nosotros_2" class="id_nosotros_2">
                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')

<script>

var eliminar = document.getElementById('Eliminar');

eliminar.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var id = button.getAttribute('data-id')
    var idModal = eliminar.querySelector('.id_nosotros_2')
    idModal.value = id;
});

$(function() {
    'use strict';


    $(function() {
        $('#reservas').DataTable({
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
            targets: [0],
            orderable: false
            }
        ]
        });
    });

});
</script>
@endpush
