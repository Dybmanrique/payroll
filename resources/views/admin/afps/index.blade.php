@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">ADMINISTRADORAS DE FONDOS DE PENSIONES</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <a href="{{ route('afps.create') }}" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                    nuevo</a>
                @livewire('afps.comission-update')
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">C. VARIABLE (%)</th>
                            <th scope="col">S. DE VIDA (%)</th>
                            <th scope="col">A. OBLIGATORIO (%)</th>
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
        .opacity-20{
            opacity: 0.2; 
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/admin/message_forms.js') }}"></script>
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
                    "data": "name",
                },
                {
                    "data": "variable_commission",
                },
                {
                    "data": "life_insurance",
                },
                {
                    "data": "obligatory_contribution",
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return (
                            `<div class="d-flex flex-row justify-content-end">
                                <a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('afps.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>
                                <button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>
                            </div>`.replace(':id', data.id)
                        );
                    }
                }
            ];

            columnDefs = [{
                    className: 'text-left text-nowrap',
                    targets: [0, 1, 2, 3, 4]
                },
                {
                    className: 'text-right',
                    targets: [5]
                },
            ];

            let table = $(`#table`).DataTable({
                "ajax": {
                    "url": "{{ route('afps.data') }}",
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
                            url: "{{ route('afps.destroy') }}",
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
            Livewire.on('refresh_afps', function(message) {
                table.ajax.reload();
            })
        });
    </script>
@stop
