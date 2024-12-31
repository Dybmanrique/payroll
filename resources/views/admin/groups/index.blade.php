@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">GRUPOS</h1>
@stop

@section('content')
    <!-- Modal View Employees -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="viewModalTitle">ASIGNADOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ol id="employees_list" class="list-group list-group-flush overflow-auto" style="max-height: 60vh"></ol>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            @can('groups.create')
                <a href="{{ route('groups.create') }}" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                    nuevo</a>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NOMBRE</th>
                            @canany(['groups.edit', 'groups.delete'])
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
                        return ` 
                        <a href="#" role="button" class="btn-view text-dark" data-toggle="modal" data-target="#viewModal">
                            <i class="fas fa-eye"></i> ${data.name}
                        </a>
                        `;
                    }
                }
            ];

            columnDefs = [{
                className: 'text-left text-nowrap',
                targets: [0, 1]
            }, ];

            $.ajax({
                url: "{{ route('groups.get_permissions') }}",
                type: "GET",
                dataType: 'json',
            }).done(function(response) {
                $(`#table`).fadeIn();

                const permissions = {
                    can_edit: response.can_edit,
                    can_delete: response.can_delete,
                }
                const buttonsTemplate = {
                    edit: `<a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('groups.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>`,
                    delete: `<button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>`
                }

                evaluatebuttonPermissions(columnAttributes, permissions, buttonsTemplate);
                table = applyDataTable('table', `{{ route('groups.data') }}`, columnAttributes, columnDefs);
            });

            $(`#table tbody`).on('click', '.btn-delete', function() {
                let data = table.row($(this).parents('tr')).data();
                deleteElement("{{ route('groups.destroy') }}", "{{ csrf_token() }}", table, data)
            });

            $(`#table tbody`).on('click', '.btn-view', function() {
                let data = table.row($(this).parents('tr')).data();
                const list = document.getElementById('employees_list');
                list.innerHTML = '';
                data.employees.forEach((employee, index) => {
                    item = document.createElement('li');
                    item.textContent = `${index + 1}. ${employee.last_name} ${employee.second_last_name} ${employee.name}`;
                    item.classList.add('list-group-item');
                    list.appendChild(item);
                });
            });
        });
    </script>
@stop
