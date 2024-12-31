@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">EMPLEADOS</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            @can('employees.create')
                <a href="{{ route('employees.create') }}" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                    nuevo</a>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">IDENTIFICACIÓN</th>
                            <th scope="col">NOMBRE</th>
                            @canany(['employees.edit', 'employees.delete'])
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
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return `[${data.identity_type.name}] ${data.identity_number}`;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return `${data.last_name} ${data.second_last_name} ${data.name}`;
                    }
                },
            ];

            columnDefs = [{
                    className: 'text-left text-nowrap',
                    targets: [0, 1, 2]
                },
            ];

            $.ajax({
                url: "{{ route('employees.get_permissions') }}",
                type: "GET",
                dataType: 'json',
            }).done(function(response) {
                $(`#table`).fadeIn();

                const permissions = {
                    can_edit: response.can_edit,
                    can_delete: response.can_delete,
                }
                const buttonsTemplate = {
                    edit: `<a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('employees.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>`,
                    delete: `<button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>`
                }

                evaluatebuttonPermissions(columnAttributes, permissions, buttonsTemplate);
                table = applyDataTable('table', `{{ route('employees.data') }}`, columnAttributes, columnDefs);
            });

            $(`#table tbody`).on('click', '.btn-delete', function() {
                let data = table.row($(this).parents('tr')).data();
                deleteElement("{{ route('employees.destroy') }}", "{{ csrf_token() }}", table, data)
            });
        });
    </script>
@stop
