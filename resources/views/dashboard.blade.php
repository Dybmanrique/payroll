@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <h1 class="font-weight-bold">PANEL DE ADMINISTRACIÓN</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $groups }}</h3>

                    <p>Grupos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('groups.index') }}" class="small-box-footer">Ir a grupos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $users }}</h3>

                    <p>Usuarios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <a href="#" class="small-box-footer">Ir a usuarios <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $employees }}</h3>

                    <p>Empleados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <a href="{{ route('employees.index') }}" class="small-box-footer">Ir a empleados <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $current_payrolls }}</h3>

                    <p>Planillas {{ date('Y') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder"></i>
                </div>
                <a href="{{ route('payrolls.index') }}" class="small-box-footer">Ir a planillas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="card">
        <div class="card-body">
            <canvas style="max-height: 400px; width: 100%;" id="myChart"></canvas>

        </div>
    </div>
@stop

@section('footer')
    <p class="text-center">UGEL - ASUNCIÓN</p>
@stop

@section('css')

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <script>
        fetch('/dashboard/estadisticas-pagos')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los datos');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data.map(item => item.period));

                const ctx = document.getElementById('myChart');

                const labels = data.map(item => item.period);
                const dataChart = {
                    labels: labels,
                    datasets: [{
                            label: 'SALARIOS BRUTOS',
                            data: data.map(item => item.total_remuneration),
                        },
                        {
                            label: 'DESCUENTOS',
                            data: data.map(item => item.total_discount),
                        },
                        {
                            label: 'SALARIOS NETOS',
                            data: data.map(item => item.net_pay),
                        },
                        {
                            label: 'ESSALUD',
                            data: data.map(item => item.total_contribution),
                        },
                        {
                            label: 'AFP',
                            data: data.map(item => item.afp_discount),
                        },
                        {
                            label: 'ONP',
                            data: data.map(item => item.onp_discount),
                        }
                    ]
                };

                const config = {
                    type: 'line',
                    data: dataChart,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'GRÁFICO DE PLANILLAS'
                            }
                        }
                    },
                };
                new Chart(ctx, config);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    </script>
@stop
