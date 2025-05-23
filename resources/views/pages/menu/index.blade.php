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
                    <h4 class="mb-3">Listado de Menus</h4>
                    <div class="mb-5">
                        @can('menu.create')
                        <a href="{{route('menu.create')}}">
                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0" >
                                <i data-feather="plus-circle"></i><b> &nbsp; Crear Menu</b>
                            </button>
                        </a>
                        @endcan
                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="agencias" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Idioma</th>
                                    @foreach($languages2 as $lanaguage)
                                        <th>{{$lanaguage->abreviatura}}</th>
                                    @endforeach
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menus as $menu)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$menu->nombre}}</td>
                                    <td>{{$menu->tipo ? 'Header':'Footer'}}</td>
                                    <td><img style="width:25px;" src="{{$menu->language?->icono}}" alt="{{$menu->language?->icono}}"></td>
                                    @foreach($languages2 as $language)
                                        <td>
                                            @php
                                                $translation = $menu->traducciones->firstWhere('language_id', $language->id);
                                                $inverseTranslation = $menu->traduccionesinversas->firstWhere('language_id', $language->id);
                                                $inverseTranslationespanol = $menu->traduccionesinversas->firstWhere('language_id', 1);

                                                $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $menu->language_id == $language->id) ? $inverseTranslationespanol : null ));                                            
                                            @endphp
                                            
                                            @if($selectedTranslation)
                                                <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->nombre}}">
                                                    <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                                                </a>
                                            @else
                                                @if($selectedTranslation)
                                                    <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->nombre}}">
                                                        <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                                                    </a>
                                                @else
                                                    <a href="{{ route('menu.traducir',['lang'=>$language->id,'menu'=>$menu]) }}">
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>{{$menu->estado ? 'Activo':'Inactivo'}}</td>
                                    <td>
                                        @can('menu.edit')
                                        <a href="{{route('menu.edit',$menu->id)}}">
                                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" >
                                                <i data-feather="edit"></i>
                                            </button>
                                        </a>
                                        @endcan
                                        @can('menu.destroy')
                                            <button type="button"  class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#Eliminar" data-id="{{$menu->id}}">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        @endcan
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

<div class="modal fade" id="Eliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('menu.destroy','test')}}" method="POST" autocomplete="off">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <p>Estas seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                        <input type="hidden" name="id_proveedor_2" class="id_proveedor_2">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
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
<script>
    var eliminar = document.getElementById('Eliminar');

    eliminar.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var idModal = eliminar.querySelector('.id_proveedor_2')
        idModal.value = id;
    });

    $(function() {
        'use strict';

        $(function() {
            $('#agencias').DataTable({
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
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",
                    }
                },
            });
        });

    });
</script>
@endpush
