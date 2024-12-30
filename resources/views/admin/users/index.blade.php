@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">USUARIOS</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            <a href="{{ route('users.create') }}" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                nuevo</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">USUARIO</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">ROLES</th>
                            <th scope="col">ACCIONES</th>
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
    <style>
        .hover-container {
            position: relative;
            display: inline-block;
        }

        .hover-card {
            position: absolute;
            top: 100%;
            /* Just below the container */
            left: 0;
            z-index: 10;
            display: none;
            width: 300px;
        }

        .hover-container:hover .hover-card {
            display: block;
        }
    </style>
@stop

@section('js')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {
            $('[data-toggle="popover"]').popover()
        })

        $(document).ready(function() {
            let columnAttributes = [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "name",
                },
                {
                    "data": "email",
                },
                {
                    "data": "roles",
                    "render": function(data, type, row, meta) {
                        roles = '<ul style="list-style: none;" class="ml-0 pl-0">';
                        if (Object.keys(data).length > 0) {
                            data.forEach(role => {
                                roles += `<li>${role.name}</li>`;
                            });
                        } else {
                            roles += `<li> Ninguno </li>`;
                        }
                        roles += '</ul>';
                        return roles;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return (
                            `<div class="d-flex flex-row justify-content-end text-nowrap">
                                <a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('users.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>
                                <button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>
                            </div>`.replace(':id', data.id)
                        );
                    }
                }
            ];

            columnDefs = [{
                    className: 'text-left text-nowrap',
                    targets: [0, 1, 2, 3]
                },
                {
                    className: 'text-right',
                    targets: [4]
                },
            ];

            let table = $(`#table`).DataTable({
                fnDrawCallback: function() {
                    $('[data-toggle="popover"]').popover({
                        container: 'body'
                    });
                },
                "ajax": {
                    "url": "{{ route('users.data') }}",
                    "type": "GET",
                    "dataSrc": "",
                },
                "columns": columnAttributes,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                columnDefs: columnDefs,
                responsive: false
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
                            url: "{{ route('users.destroy') }}",
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
