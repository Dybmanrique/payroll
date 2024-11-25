@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">GRUPOS</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            <a href="{{ route('groups.create') }}" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                nuevo</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NOMBRE</th>                            
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
                    "data": null,
                    "render": function(data, type, row, meta) {
                        template = "";
                        if(data.employees.length>0){
                            data.employees.forEach(employee => {
                                template += `<li>${employee.last_name} ${employee.second_last_name} ${employee.name}</li>`;
                            });
                        }else{
                            template += `<li>Ninguno asignado</li>`
                        }
                        return (
                            `
                            <div class="d-flex flex-row justify-content-end">
                                <a tabindex="0" class="btn btn-sm btn-success mr-2 font-weight-bold" role="button" data-toggle="popover" data-trigger="focus" data-html="true" 
                                   data-content="
                                   <span class='font-weight-bold'>LISTA DE ASIGNADOS</span>
                                   <ul class='px-3'>
                                   ${template}
                                   </ul>
                                   ">
                                   <i class='fas fa-user-friends'></i> ASIGNADOS
                               </a>
                                <a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('groups.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>
                                <button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>
                            </div>`.replace(':id', data.id)
                        );
                    }
                }
            ];

            columnDefs = [{
                    className: 'text-left text-nowrap',
                    targets: [0, 1]
                },
                {
                    className: 'text-right',
                    targets: [2]
                },
            ];

            let table = $(`#table`).DataTable({
                fnDrawCallback: function() {
                    $('[data-toggle="popover"]').popover({
                        container: 'body'
                    });
                },
                "ajax": {
                    "url": "{{ route('groups.data') }}",
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
                            url: "{{ route('groups.destroy') }}",
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
