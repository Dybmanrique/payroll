@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">PLANILLAS</h1>
@stop

@section('content')
    <!-- Modal View Payroll -->
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewLabel">VER PLANILLA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display:none;" id="loader">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span class="ml-2 font-weight-bold">CARGANDO...</span>
                        </div>
                    </div>
                    <div class="row" id="contentSection">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th class="font-weight-bold">NÚMERO</th>
                                                <td>: <span id="modal_number">001-2024</span></td>
                                            </tr>
                                            <tr>
                                                <th class="font-weight-bold">PERIODO</th>
                                                <td>: <span id="modal_period">202410</span></td>
                                            </tr>
                                            <tr>
                                                <th class="font-weight-bold">FECHA DE PROCESO</th>
                                                <td>: <span id="modal_processing_date">10-10-2024</span></td>
                                            </tr>
                                            <tr>
                                                <th class="font-weight-bold">TIPO DE PLANILLA</th>
                                                <td>: <span id="modal_payroll_type">CAS</span></td>
                                            </tr>
                                            <tr>
                                                <th class="font-weight-bold">FUENTE DE FINANCIAMIENTO</th>
                                                <td>: <span id="modal_funding_resource">[00] FUENTE DE FINANCIAMIENTO
                                                        X</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <button onclick="abrirNuevaPestana()" class="btn btn-primary w-100"
                                        type="button">Generar
                                        MCPP</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <span>LISTA DE EMPLEADOS</span>
                                    <div class="table-responsive" style="max-height: 800px">
                                        <table id="table_view" class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">DNI</th>
                                                    <th scope="col">EMPLEADO</th>
                                                    <th scope="col">REMUNERACIÓN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button type="submit" class="btn btn-primary">ACEPTAR</button>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <a href="{{ route('payrolls.create') }}" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                nuevo</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm w-100 my-2 " id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NÚMERO</th>
                            <th scope="col">PERIODO</th>
                            <th scope="col">FECHA PROCESO</th>
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

@stop

@section('js')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        let idSelected = 0;

        $(document).ready(function() {
            let columnAttributes = [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "number",
                },
                {
                    "data": "period",
                },
                {
                    "data": "processing_date",
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return (
                            `<div class="d-flex flex-row justify-content-end">
                                <button class="btn btn-sm btn-info mr-2 font-weight-bold btn-view" type="button" data-toggle="modal" data-target="#modalView"><i class=" fas fa-eye"></i> VISUALIZAR</button>
                                <a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="{{ route('payrolls.edit', ':id') }}"><i class="far fa-edit"></i> EDITAR</a>
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
                "ajax": {
                    "url": "{{ route('payrolls.data') }}",
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
                            url: "{{ route('payrolls.destroy') }}",
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

            $(`#table tbody`).on('click', '.btn-view', function() {
                $('#loader').show();
                $('#contentSection').hide();
                let data = table.row($(this).parents('tr')).data();
                idSelected = data["id"];
                $.ajax({
                    url: "{{ route('payrolls.view') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: data["id"],
                    }
                }).done(function(response) {
                    if (response.code == '200') {
                        $('#modal_number').text(response.content.number);
                        $('#modal_period').text(response.content.period);
                        $('#modal_processing_date').text(response.content.processing_date);
                        let tableBody = $('#table_view tbody');
                        tableBody.empty();
                        response.content.employees.forEach((employee, index) => {
                            let row = $('<tr></tr>');

                            row.append(`<td>${index + 1}</td>`);
                            row.append(`<td>${employee.dni}</td>`);
                            row.append(
                                `<td>${employee.last_name} ${employee.second_last_name} ${employee.name}</td>`
                            );
                            row.append(`<td>${employee.remuneration}</td>`);

                            tableBody.append(row);
                        });
                        $('#loader').hide();
                        $('#contentSection').fadeIn();
                    } else if (response.code == '500') {
                        Toast.fire({
                            icon: 'info',
                            title: response.content
                        });
                    }
                });
            });

        });
        function abrirNuevaPestana() {
            route_mcpp = "{{ route('payrolls.mcpp', ':id') }}";

            window.open(route_mcpp.replace(':id', idSelected), '_blank');
        }
    </script>
@stop
