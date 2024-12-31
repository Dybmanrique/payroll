@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">METAS PRESUPUESTALES</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            @can('budgetary_objectives.create')
                <a href="{{ route('budgetary_objectives.create') }}"
                    class="btn btn-primary text-uppercase font-weight-bold">Registrar
                    nuevo</a>
            @endcan
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
                            @canany(['budgetary_objectives.edit', 'budgetary_objectives.delete'])
                                <th scope="col" class="text-center">ACCIONES</th>
                            @endcanany
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
    <script src="{{ asset('js/admin/message_forms.js') }}"></script>
    <script src="{{ asset('js/admin/crud.js') }}"></script>
    <script>
        $(`#table`).hide();

        $(document).ready(function() {
            let table;
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
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return (
                            `<span title='${data.name}' class="d-inline-block text-truncate" style="max-width: 400px;">
                                ${data.name}
                            </span>`
                        );
                    }
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
            ];

            columnDefs = [{
                    className: 'text-left text-nowrap',
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                },
            ];

            $.ajax({
                url: "{{ route('budgetary_objectives.get_permissions') }}",
                type: "GET",
                dataType: 'json',
            }).done(function(response) {
                $(`#table`).fadeIn();

                const permissions = {
                    can_edit: response.can_edit,
                    can_delete: response.can_delete,
                }
                const buttonsTemplate = {
                    edit: `<a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('budgetary_objectives.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>`,
                    delete: `<button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>`
                }

                evaluatebuttonPermissions(columnAttributes, permissions, buttonsTemplate);
                table = applyDataTable('table', `{{ route('budgetary_objectives.data') }}`, columnAttributes, columnDefs);
            });

            $(`#table tbody`).on('click', '.btn-delete', function() {
                let data = table.row($(this).parents('tr')).data();
                deleteElement("{{ route('budgetary_objectives.destroy') }}", "{{ csrf_token() }}", table, data)
            });
        });
    </script>
@stop
