@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">METAS PRESUPUESTALES</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            <a href="{{ route('budgetary_objectives.create') }}"
                class="btn btn-primary text-uppercase font-weight-bold">Registrar
                nuevo</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-nowrap" scope="col">#</th>
                            <th class="text-nowrap" scope="col">AÑO</th>
                            <th class="text-nowrap" scope="col">FINALIDAD</th>
                            <th class="text-nowrap" scope="col">PROGRAMA P.</th>
                            <th class="text-nowrap" scope="col">PRODUCTO/PROYECTO</th>
                            <th class="text-nowrap" scope="col">ACTIVIDAD/OBRA</th>
                            <th class="text-nowrap" scope="col">FUNCIÓN</th>
                            <th class="text-nowrap" scope="col">DIVISIÓN FN.</th>
                            <th class="text-nowrap" scope="col">GRUPO FN.</th>
                            <th class="text-nowrap" scope="col">SECUENCIA FUNCIONAL</th>
                            <th class="text-nowrap" scope="col">CLASIFICADOR CAS</th>
                            <th class="text-nowrap" scope="col">CLASIFICADOR ESSALUD</th>
                            <th class="text-nowrap" scope="col">CLASIFICADOR AGUINALDO</th>
                            <th class="text-nowrap" scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
@stop

@section('footer')
    <p class="text-center">UGEL - ASUNCIÓN</p>
@stop

@section('css')

@stop

@section('js')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(document).ready(function() {

            let columnAttributes = [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "year",
                },
                {
                    "data": "name",
                },
                {
                    "data": "programa_pptal",
                },
                {
                    "data": "producto_proyecto",
                },
                {
                    "data": "activ_obra_accinv",
                },
                {
                    "data": "funcion",
                },
                {
                    "data": "division_fn",
                },
                {
                    "data": "grupo_fn",
                },
                {
                    "data": "sec_func",
                },
                {
                    "data": "cas_classifier",
                },
                {
                    "data": "essalud_classifier",
                },
                {
                    "data": "aguinaldo_classifier",
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return (
                            `<div class="d-flex flex-row justify-content-end">
                                <a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('budgetary_objectives.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>
                                <button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>
                            </div>`.replace(':id', data.id)
                        );
                    }
                }
            ];

            columnDefs = [{
                    className: 'text-left text-nowrap',
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                },
                {
                    className: 'text-right',
                    targets: []
                },
            ];

            let table = $(`#table`).DataTable({
                "ajax": {
                    "url": "{{ route('budgetary_objectives.data') }}",
                    "type": "GET",
                    "dataSrc": "",
                },
                "columns": columnAttributes,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                columnDefs: columnDefs,
                responsive: true
            });

            $(`#table tbody`).on('click', '.btn-delete', function() {
                let data = table.row($(this).parents('tr')).data();

                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Esta acción no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1e40af',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SÍ, ELIMINAR!',
                    cancelButtonText: 'CANCELAR'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('budgetary_objectives.destroy') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: data["id"],
                            }
                        }).done(function(response) {
                            if (response.code == '200') {
                                table.ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                            } else if (response.code == '500') {
                                Toast.fire({
                                    icon: 'info',
                                    title: response.message
                                });
                            }
                        });
                    }
                })
            });
        });
    </script>
@stop
