<div class="pb-3">
    <!-- Modal Add Period -->
    <div wire:ignore.self class="modal fade" id="modalPeriod" tabindex="-1" role="dialog"
        aria-labelledby="modalPeriodLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="modalPeriodLabel">AGREGAR PERIODO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            @foreach ($periods as $index => $period)
                                <div class="col-md-4">
                                    <button wire:click='addPeriod({{ $index }})' wire:loading.attr='disabled'
                                        class="btn btn-success w-100 mt-2">{{ $period }}</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Employee -->
    <div wire:ignore.self class="modal fade" id="modalEmployee" tabindex="-1" role="dialog"
        aria-labelledby="modalEmployeeLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="modalEmployeeLabel">AGREGAR EMPLEADO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div wire:ignore class="form-group">
                                <label for="modal_employee_id">Lista de empleados*:</label>
                                <div class="row">
                                    <div class="col-9 col-lg-10">
                                        <select id="modal_employee_id" class="form-control select2"
                                            data-placeholder="Seleccione un empleado" required>
                                            <option></option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">[{{ $employee->identity_number }}]
                                                    {{ $employee->last_name }} {{ $employee->second_last_name }} {{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-success col-3 col-lg-2" title="Volver a cargar"
                                        onclick="searchContracts()"><i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('modal_employee_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-7">
                            <span class="font-weight-bold">CONTRATOS VIGENTES</span>
                            <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full'
                                wire:target="searchContracts">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center justify-items-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <span class="text-md ml-2 font-weight-bold">BUSCANDO...</span>
                                    </div>
                                </div>
                            </div>
                            <div wire:loading.class='d-none' wire:target="searchContracts">
                                @if ($employee_target)
                                    <a href="{{ route('employees.edit', $employee_target->id) }}#contratos"
                                        target="_blank" class="font-weight-bold btn btn-sm btn-outline-info w-100 mb-2">
                                        <i class="fas fa-eye"></i> VER CONTRATOS
                                    </a>

                                    @forelse ($employee_target->current_contracts as $contract)
                                        <div class="shadow-sm rounded border mb-2 p-3" wire:key='{{ $contract->id }}'>
                                            <div class="w-100">
                                                <div><span class="font-weight-bold">VIGENCIA:</span>
                                                    Desde el {{ date('d-m-Y', strtotime($contract->start_validity)) }}
                                                    hasta el
                                                    {{ date('d-m-Y', strtotime($contract->end_validity)) }}
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4"><span
                                                            class="font-weight-bold">REMUNERACIÓN:</span>
                                                        {{ $contract->remuneration }}
                                                    </div>
                                                    <div class="col-md-8"><span class="font-weight-bold">META:</span>
                                                        {{ $contract->budgetary_objective->name }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4"><span class="font-weight-bold">NIVEL:</span>
                                                        {{ $contract->level->name }}
                                                    </div>
                                                    <div class="col-md-4"><span class="font-weight-bold">CARGO:</span>
                                                        {{ $contract->job_position->name }}
                                                    </div>
                                                    <div class="col-md-4"><span class="font-weight-bold">JORNADA
                                                            L.:</span>
                                                        {{ $contract->working_hours }} horas
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-primary btn-sm mb-1 w-100 font-weight-bold"
                                                    wire:loading.attr='disabled' wire:target='addContract'
                                                    wire:click='addContract({{ $contract->id }})'>
                                                    <i class="fas fa-plus"></i> AGREGAR
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="card">
                                            <div class="card-body text-center">
                                                Ningún contrato disponible
                                            </div>
                                        </div>
                                    @endforelse
                                @else
                                    <div class="card">
                                        <div class="card-body text-center">
                                            Seleccione un empleado para buscar sus contratos
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Group -->
    <div wire:ignore.self class="modal fade" id="modalGroup" tabindex="-1" role="dialog"
        aria-labelledby="modalGroupLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="modalGroupLabel">AGREGAR POR GRUPO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modal_group_id">Lista de grupos*:</label>
                                <div class="row">
                                    <div class="col-9 col-lg-10 mx-1">
                                        <select name="modal_group_id" id="modal_group_id" class="form-control" required>
                                            <option value="">--Seleccione--</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button class="btn btn-success col-3 col-lg-2" title="Volver a cargar"
                                        onclick="searchContractsGroup()"><i class="fas fa-sync-alt"></i></button>
                                </div>
                                @error('modal_group_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <span class="font-weight-bold text-lg">CONTRATOS VIGENTES</span>
                            <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full'
                                wire:target="searchContractsGroup">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center justify-items-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <span class="text-md ml-2 font-weight-bold">BUSCANDO...</span>
                                    </div>
                                </div>
                            </div>
                            <div wire:loading.class='d-none' wire:target="searchContractsGroup">
                                @forelse ($employees_group_list as $employee)
                                    <div class="row align-items-center">
                                        <div class="col-md-6 font-weight-bold mb-2">
                                            {{ $employee->last_name }} {{ $employee->second_last_name }}
                                            {{ $employee->name }}
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('employees.edit', $employee->id) }}#contratos"
                                                target="_blank"
                                                class="font-weight-bold btn btn-sm btn-outline-info w-100 mb-2">
                                                <i class="fas fa-eye"></i> VER CONTRATOS
                                            </a>
                                        </div>
                                    </div>


                                    @forelse ($employee->current_contracts as $contract)
                                        <div class="shadow-sm rounded border mb-2 p-3"
                                            wire:key='{{ $contract->id }}'>
                                            <div class="w-100">
                                                <div><span class="font-weight-bold">VIGENCIA:</span>
                                                    Desde el
                                                    {{ date('d-m-Y', strtotime($contract->start_validity)) }}
                                                    hasta el
                                                    {{ date('d-m-Y', strtotime($contract->end_validity)) }}
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4"><span
                                                            class="font-weight-bold">REMUNERACIÓN:</span>
                                                        {{ $contract->remuneration }}
                                                    </div>
                                                    <div class="col-md-8"><span class="font-weight-bold">META:</span>
                                                        {{ $contract->budgetary_objective->name }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4"><span class="font-weight-bold">NIVEL:</span>
                                                        {{ $contract->level->name }}
                                                    </div>
                                                    <div class="col-md-4"><span class="font-weight-bold">CARGO:</span>
                                                        {{ $contract->job_position->name }}
                                                    </div>
                                                    <div class="col-md-4"><span class="font-weight-bold">JORNADA
                                                            L.:</span>
                                                        {{ $contract->working_hours }} horas
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-primary btn-sm mb-1 w-100 font-weight-bold"
                                                    wire:loading.attr='disabled' wire:target='addContract'
                                                    wire:click='addContract({{ $contract->id }})'>
                                                    <i class="fas fa-plus"></i> AGREGAR
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="shadow-sm border rounded-sm p-2 mb-2">
                                            No tiene contratos vigentes
                                        </div>
                                    @endforelse
                                @empty
                                    <div class="card">
                                        <div class="card-body text-center">
                                            Ningún contrato disponible
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal AFP NET -->
    <div wire:ignore.self class="modal fade" id="modalAfpNet" tabindex="-1" role="dialog"
        aria-labelledby="modalAfpNetLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form wire:submit='exportAfpNet()'>
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalAfpNetLabel">EXPORTAR AFP NET</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full'
                            wire:target="prepare_afp_net">
                            <div class="card-body">
                                <div class="d-flex justify-content-center justify-items-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span class="text-md ml-2 font-weight-bold">BUSCANDO...</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive  text-nowrap" style="max-height: 65vh" wire:loading.class='d-none'
                            wire:target="prepare_afp_net">
                            @if (count($afp_net_list) > 0)
                                <table class="table table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col" class="align-middle" class="align-middle"
                                                rowspan="2">ACCIONES</th>
                                            <th scope="col" class="align-middle" class="align-middle"
                                                rowspan="2">N°</th>
                                            <th scope="col" class="align-middle" rowspan="2">CUSPP</th>
                                            <th scope="col" class="align-middle" rowspan="2" colspan="2">
                                                IDENTIFICACIÓN</th>
                                            <th scope="col" class="align-middle" rowspan="2">APELLIDO P.</th>
                                            <th scope="col" class="align-middle" rowspan="2">APELLIDO M.</th>
                                            <th scope="col" class="align-middle" rowspan="2">NOMBRES</th>
                                            <th scope="col" class="align-middle" rowspan="2"
                                                style="min-width: 110px" title="RELACIÓN LABORAL">RELACIÓN L.</th>
                                            <th scope="col" class="align-middle" rowspan="2"
                                                style="min-width: 110px" title="INICIO DE RELACIÓN LABORAL">INICIO
                                                R.L.</th>
                                            <th scope="col" class="align-middle" rowspan="2"
                                                style="min-width: 110px" title="CESE DE RELACIÓN LABORAL">CESE R.L.
                                            </th>
                                            <th scope="col" class="align-middle" rowspan="2">EXCEPCIÓN DE
                                                APORTAR</th>
                                            <th scope="col" class="align-middle" rowspan="2">REMUNERACIÓN</th>
                                            <th scope="col" class="text-center" colspan="3">APORTES VOLUNTARIOS
                                            </th>
                                            <th scope="col" class="align-middle" rowspan="2"
                                                style="min-width: 250px">TIPO TRABAJO</th>
                                        </tr>
                                        <tr>
                                            <th scope="col"
                                                title="APORTE VOLUNTARIO DEL AFILIADO CON FIN PREVISIONAL">DEL AFILIADO
                                                C.F.P.</th>
                                            <th scope="col"
                                                title="APORTE VOLUNTARIO DEL AFILIADO SIN FIN PREVISIONAL">DEL AFILIADO
                                                S.N.P.</th>
                                            <th scope="col">DEL EMPLEADOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($afp_net_list as $index => $item)
                                            <tr>
                                                <th scope="row">
                                                    <a href="{{ route('employees.edit', $item['employee']) }}#contratos"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> VER CONTRATOS
                                                    </a>
                                                </th>
                                                <th scope="row">{{ $item['afp_atributes'][0] }}</th>
                                                <td scope="col">{{ $item['afp_atributes'][1] }}</td>
                                                <td scope="col">{{ $type_id_afp[$item['afp_atributes'][2]] }}</td>
                                                <td scope="col">{{ $item['afp_atributes'][3] }}</td>
                                                <td scope="col">{{ $item['afp_atributes'][4] }}</td>
                                                <td scope="col">{{ $item['afp_atributes'][5] }}</td>
                                                <td scope="col">{{ $item['afp_atributes'][6] }}</td>
                                                <td scope="col">
                                                    <select
                                                        onchange="changeValueAfp({{ $index }}, 7, this.value)"
                                                        class="form-control">
                                                        <option value="S" selected>SI</option>
                                                        <option value="N">NO</option>
                                                    </select>
                                                </td>
                                                <td scope="col">
                                                    <select
                                                        onchange="changeValueAfp({{ $index }}, 8, this.value)"
                                                        class="form-control">
                                                        <option value="S">SI</option>
                                                        <option value="N" selected>NO</option>
                                                    </select>
                                                </td>
                                                <td scope="col">
                                                    <select
                                                        onchange="changeValueAfp({{ $index }}, 9, this.value)"
                                                        class="form-control">
                                                        <option value="S">SI</option>
                                                        <option value="N" selected>NO</option>
                                                    </select>
                                                </td>
                                                <td scope="col">
                                                    <select
                                                        onchange="changeValueAfp({{ $index }}, 10, this.value)"
                                                        class="form-control">
                                                        <option value="" selected>SI APORTA</option>
                                                        <option value="L">LICENCIA SIN GOCE DE HABER</option>
                                                        <option value="U">SUBSIDIO POR ESSALUD</option>
                                                        <option value="J">AFILIADO PENSIONADO POR JUBILACIÓN
                                                        </option>
                                                        <option value="I">AFILIADO PENSIONADO POR INVALIDEZ
                                                        </option>
                                                        <option value="P">APORTE POSTERGADO POR INICIO DE RL
                                                        </option>
                                                        <option value="O">OTRO MOTIVO</option>
                                                    </select>
                                                </td>
                                                <td scope="col">
                                                    <input type="number"
                                                        value="{{ number_format($item['afp_atributes'][11], 2, '.', '') }}"
                                                        step="0.01" class="form-control"
                                                        onchange="changeValueAfp({{ $index }}, 11, this.value)">
                                                </td>
                                                <td scope="col">
                                                    <input type="number" value="0" class="form-control"
                                                        onchange="changeValueAfp({{ $index }}, 12, this.value)">
                                                </td>
                                                <td scope="col">
                                                    <input type="number" value="0" class="form-control"
                                                        onchange="changeValueAfp({{ $index }}, 13, this.value)">
                                                </td>
                                                <td scope="col">
                                                    <input type="number" value="0" class="form-control"
                                                        onchange="changeValueAfp({{ $index }}, 14, this.value)">
                                                </td>
                                                <td scope="col">
                                                    <select
                                                        onchange="changeValueAfp({{ $index }}, 15, this.value)"
                                                        class="form-control">
                                                        <option value="N" selected>DEPENDIENTE NORMAL</option>
                                                        <option value="C">DEPENDIENTE CONSTRUCCIÓN</option>
                                                        <option value="M">DEPENDIENTE MINERÍA</option>
                                                        <option value="P">PESQUERO</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="font-weight-bold text-center rounded-sm border shadow-sm m-1 p-2">
                                    NINGÚN REGISTRO AFP ENCONTRADO
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'>EXPORTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal JOR -->
    <div wire:ignore.self class="modal fade" id="modalJor" tabindex="-1" role="dialog"
        aria-labelledby="modalJorLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form wire:submit='exportJor()'>
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalJorLabel">EXPORTAR DATOS DE JORNADA LABORAL
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full'
                            wire:target="prepare_jor">
                            <div class="card-body">
                                <div class="d-flex justify-content-center justify-items-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span class="text-md ml-2 font-weight-bold">CARGANDO...</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-nowrap" wire:loading.class='d-none' wire:target="prepare_jor">
                            @if (count($jor_list) > 0)
                                <div class="table-responsive" style="max-height: 65vh">

                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="align-middle" class="align-middle">ACCIONES
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">N°</th>
                                                <th scope="col" class="align-middle" class="align-middle">
                                                    IDENTIFICACIÓN</th>
                                                <th scope="col" class="align-middle" class="align-middle">EMPLEADO
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">HORAS
                                                    ORDINARIAS</th>
                                                <th scope="col" class="align-middle" class="align-middle">MINUTOS
                                                    ORDINARIOS</th>
                                                <th scope="col" class="align-middle" class="align-middle">HORAS
                                                    SOBRETIEMPO</th>
                                                <th scope="col" class="align-middle" class="align-middle">MINUTOS
                                                    SOBRETIEMPO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jor_list as $index => $item)
                                                <tr>
                                                    <th scope="row">
                                                        <a href="{{ route('employees.edit', $item['employee']) }}#contratos"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> VER CONTRATOS
                                                        </a>
                                                    </th>
                                                    <th scope="row">{{ $index + 1 }}</th>
                                                    <td scope="col">{{ $item['employee']->identity_type->name }}
                                                        {{ $item['jor_atributes'][1] }}</td>
                                                    <td scope="col">{{ $item['employee']->last_name }}
                                                        {{ $item['employee']->second_last_name }}
                                                        {{ $item['employee']->name }}</td>
                                                    <td scope="col">
                                                        <input type="number" value="{{ $item['jor_atributes'][2] }}"
                                                            class="form-control"
                                                            onchange="changeValueJor({{ $index }}, 2, this.value)">
                                                    </td>
                                                    <td scope="col">
                                                        <input type="number" value="0" class="form-control"
                                                            onchange="changeValueJor({{ $index }}, 3, this.value)">
                                                    </td>
                                                    <td scope="col">
                                                        <input type="number" value="0" class="form-control"
                                                            onchange="changeValueJor({{ $index }}, 4, this.value)">
                                                    </td>
                                                    <td scope="col">
                                                        <input type="number" value="0" class="form-control"
                                                            onchange="changeValueJor({{ $index }}, 5, this.value)">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="font-weight-bold text-center rounded-sm border shadow-sm m-1 p-2">
                                    NINGÚN REGISTRO AFP ENCONTRADO
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'>EXPORTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal REM -->
    <div wire:ignore.self class="modal fade" id="modalRem" tabindex="-1" role="dialog"
        aria-labelledby="modalRemLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form wire:submit='export_rem()'>
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalJorLabel">EXPORTAR DATOS DE INGRESOS,
                            TRIBUTOS Y DESCUENTOS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full'
                            wire:target="prepare_rem">
                            <div class="card-body">
                                <div class="d-flex justify-content-center justify-items-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span class="text-md ml-2 font-weight-bold">CARGANDO...</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-nowrap" wire:loading.class='d-none' wire:target="prepare_rem">
                            @if (count($rem_list) > 0)
                                <div class="table-responsive" style="max-height: 65vh">
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="align-middle" class="align-middle">ACCIONES
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">N°</th>
                                                <th scope="col" class="align-middle" class="align-middle">
                                                    IDENTIFICACIÓN</th>
                                                <th scope="col" class="align-middle" class="align-middle">EMPLEADO
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">CONCEPTO
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">MONTO
                                                    DEVENGADO</th>
                                                <th scope="col" class="align-middle" class="align-middle">MONTO
                                                    PAGADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rem_list as $index => $item)
                                                <tr>
                                                    <th scope="row" rowspan="{{ count($item['rem_items']) }}">
                                                        <a href="{{ route('employees.edit', $item['employee']) }}#contratos"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> VER CONTRATOS
                                                        </a>
                                                    </th>
                                                    <th scope="row" rowspan="{{ count($item['rem_items']) }}">
                                                        {{ $index + 1 }}</th>
                                                    <td scope="col" rowspan="{{ count($item['rem_items']) }}">
                                                        {{ $item['employee']->identity_type->name }}
                                                        {{ $item['employee']->identity_number }}</td>
                                                    <td scope="col" rowspan="{{ count($item['rem_items']) }}">
                                                        {{ $item['employee']->last_name }}
                                                        {{ $item['employee']->second_last_name }}
                                                        {{ $item['employee']->name }}</td>
                                                
                                                @foreach ($item['rem_items'] as $rem_item)
                                                    @if(!$loop->first)
                                                        <tr>
                                                    @endif
                                                        <td scope="col">({{ $rem_item[2] }}) {{ $rem_codes[$rem_item[2]] }}</td>
                                                        <td scope="col">{{ $rem_item[3] }}</td>
                                                        <td scope="col">{{ $rem_item[4] }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="font-weight-bold text-center rounded-sm border shadow-sm m-1 p-2">
                                    NINGÚN REGISTRO AFP ENCONTRADO
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'>EXPORTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal MCPP -->
    <div wire:ignore.self class="modal fade" id="modalMcpp" tabindex="-1" role="dialog"
        aria-labelledby="modalMcppLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form wire:submit='export_mcpp()'>
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalJorLabel">EXPORTAR DATOS MCPP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full'
                            wire:target="prepare_mcpp">
                            <div class="card-body">
                                <div class="d-flex justify-content-center justify-items-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span class="text-md ml-2 font-weight-bold">CARGANDO...</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-nowrap" wire:loading.class='d-none' wire:target="prepare_mcpp">
                            @if (count($mcpp_list) > 0)
                                <div class='d-flex flex-row align-items-center'>
                                    <span class="font-weight-bold mr-2">N°:</span>
                                    <input type="text" class='form-control' style='max-width: 200px;' wire:model='mcpp_correlative'>
                                </div>
                                <hr>
                                <div class="table-responsive" style="max-height: 65vh">
                                    <div class="row mb-3">
                                        <div class="col-md-6 col-xl-3"><span class="font-weight-bold">N° FILAS:</span> {{ $mcpp_list['header'][6] }}</div>
                                        <div class="col-md-6 col-xl-3"><span class="font-weight-bold">TOTAL INGRESOS:</span> {{ $mcpp_list['header'][7] }}</div>
                                        <div class="col-md-6 col-xl-3"><span class="font-weight-bold">TOTAL DESCUENTOS:</span> {{ $mcpp_list['header'][8] }}</div>
                                        <div class="col-md-6 col-xl-3"><span class="font-weight-bold">TOTAL APORTES:</span> {{ $mcpp_list['header'][9] }}</div>
                                    </div>
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="align-middle" class="align-middle">ACCIONES
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">N°</th>
                                                <th scope="col" class="align-middle" class="align-middle">
                                                    IDENTIFICACIÓN</th>
                                                <th scope="col" class="align-middle" class="align-middle">EMPLEADO
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">F. FINANCIAMIENTO
                                                </th>
                                                <th scope="col" class="align-middle" class="align-middle">TIPO CONCEPTO</th>
                                                <th scope="col" class="align-middle" class="align-middle">CONCEPTO</th>
                                                <th scope="col" class="align-middle" class="align-middle">MONTO</th>
                                                <th scope="col" class="align-middle" class="align-middle">TIPO REGISTRO</th>
                                                <th scope="col" class="align-middle" class="align-middle">COD. AIRHSP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mcpp_list['mcpp_list'] as $index => $item)
                                                <tr>
                                                    <th scope="row" rowspan="{{ count($item['mcpp_items']) }}">
                                                        <a href="{{ route('employees.edit', $item['employee']) }}#contratos"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> VER CONTRATOS
                                                        </a>
                                                    </th>
                                                    <th scope="row" rowspan="{{ count($item['mcpp_items']) }}">
                                                        {{ $index + 1 }}</th>
                                                    <td scope="col" rowspan="{{ count($item['mcpp_items']) }}">
                                                        {{ $item['employee']->identity_type->name }}
                                                        {{ $item['employee']->identity_number }}</td>
                                                    <td scope="col" rowspan="{{ count($item['mcpp_items']) }}">
                                                        {{ $item['employee']->last_name }}
                                                        {{ $item['employee']->second_last_name }}
                                                        {{ $item['employee']->name }}</td>
                                                
                                                @foreach ($item['mcpp_items'] as $rem_item)
                                                    @if(!$loop->first)
                                                        <tr>
                                                    @endif
                                                        <td scope="col">({{ $rem_item[2] }}) {{ $funding_resources_array[$rem_item[2]] }}</td>
                                                        <td scope="col">({{ $rem_item[3] }}) {{ $mcpp_concepts['TIPO_CONCEPTO']['BY_CODE'][$rem_item[3]] }}</td>
                                                        <td scope="col">({{ $rem_item[4] }}) {{ $rem_item[5] }}</td>
                                                        <td scope="col" class="text-right">{{ $rem_item[6] }}</td>
                                                        <td scope="col" class="text-center">{{ $mcpp_concepts['CODIGOS_TIPO_REGISTRO']['BY_CODE'][$rem_item[7]] }}</td>
                                                        <td scope="col">{{ $rem_item[8] ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="font-weight-bold text-center rounded-sm border shadow-sm m-1 p-2">
                                    NINGÚN REGISTRO AFP ENCONTRADO
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'>EXPORTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <form wire:submit='save'>
            <div class="card-header">
                <span class="font-weight-bold">DATOS DE LA PLANILLA</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="number">Número*:</label>
                        <input type="text" wire:model='number' id="number" class="form-control"
                            placeholder="Ingrese el número" required autocomplete="off">
                        @error('number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="year">Año*:</label>
                        <input type="text" wire:model='year' id="year" class="form-control"
                            placeholder="Ingrese el número" required autocomplete="off">
                        @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="payroll_type_id">Tipo de planilla*:</label>
                        <select wire:model="payroll_type_id" id="payroll_type_id" class="form-control" required>
                            <option value="">--Seleccione--</option>
                            @foreach ($payroll_types as $payroll_type)
                                <option value="{{ $payroll_type->id }}">{{ $payroll_type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('payroll_type_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="funding_resource_id">Fuente de financiamiento*:</label>
                        <select wire:model="funding_resource_id" id="funding_resource_id" class="form-control"
                            required>
                            <option value="">--Seleccione--</option>
                            @foreach ($funding_resources as $funding_resource)
                                <option value="{{ $funding_resource->id }}">
                                    [{{ $funding_resource->code }}]
                                    {{ $funding_resource->name }}</option>
                            @endforeach
                        </select>
                        @error('funding_resource_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Nombre*:</label>
                        <input type="text" wire:model='name' id="name" class="form-control"
                            placeholder="Ingrese el nombre de la planilla" required autocomplete="off">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right font-weight-bold text-uppercase"><i
                        class="fas fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span class="font-weight-bold">PERIODOS</span>
                <div>
                    <button class="btn btn-secondary btn-sm font-weight-bold" type="button" data-toggle="modal"
                        data-target="#modalPeriod">AGREGAR</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit="searchEmployees">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-info font-weight-bold"><i
                                    class="fas fa-search"></i> BUSCAR</button>
                        </div>
                        <select id="selected_period" wire:model="selected_period" class="form-control" required>
                            <option value="">--Seleccione un periodo--</option>
                            @foreach ($periods_payroll as $period)
                                <option value="{{ $period->id }}" wire:key='{{ $period->id }}'>
                                    {{ $periods[$period->mounth] }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button type="button" onclick='deletePeriod()' wire:loading.attr='disabled'
                                wire:target='deletePeriod' class="btn btn-danger font-weight-bold rounded-right"><i
                                    class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    @error('selected_period')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </div>
    </div>

    <div class="card d-none opacity-low" wire:loading.class='d-block opacity-full' wire:target="searchEmployees">
        <div class="card-body">
            <div class="d-flex justify-content-center justify-items-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <span class="text-md ml-2 font-weight-bold">BUSCANDO...</span>
            </div>
        </div>
    </div>
    <div wire:loading.class='d-none' wire:target="searchEmployees">
        @if ($payments_list)
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">LISTA DE EMPLEADOS</div>
                        <div class="col-md-6 text-right">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="w-100 mt-1 btn btn-secondary btn-sm font-weight-bold"
                                        type="button" data-toggle="modal"
                                        data-target="#modalEmployee">AGREGAR</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="w-100 mt-1 btn btn-dark btn-sm font-weight-bold" type="button"
                                        data-toggle="modal" data-target="#modalGroup">AGREGAR VARIOS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($payments_list) >= 1)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ACCIONES</th>
                                        <th scope="col">IDENTIFICACIÓN</th>
                                        <th scope="col">EMPLEADO</th>
                                        <th scope="col">META</th>
                                        <th scope="col" style="min-width: 120px">BÁSICO</th>
                                        <th scope="col" style="min-width: 120px">PAGO NETO</th>
                                        <th scope="col" style="min-width: 90px">DÍAS</th>
                                        <th scope="col" style="min-width: 90px">D. DÍAS</th>
                                        <th scope="col" style="min-width: 90px">D. HORAS</th>
                                        <th scope="col" style="min-width: 90px">D. MIN.</th>
                                        <th scope="col" style="min-width: 120px">REINTEGRO</th>
                                        <th scope="col" style="min-width: 120px">AGUINALDO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments_list as $index => $payment)
                                        <tr wire:key='{{ $payment->id }}'>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-right text-nowrap">
                                                <a href="{{ route('payrolls.generate_payment_slip', $payment->id) }}"
                                                    class="btn btn-sm btn-secondary" target="_blank">
                                                    <i class="fas fa-file-alt"></i> BOLETA
                                                </a>
                                                <button onclick='deleteContract({{ $payment->id }})' type="button"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                    ELIMINAR
                                                </button>
                                            </td>
                                            <td>[{{ $payment->contract->employee->identity_type->name }}]
                                                {{ $payment->contract->employee->identity_number }}</td>
                                            <td class="text-nowrap">{{ $payment->contract->employee->last_name }}
                                                {{ $payment->contract->employee->second_last_name }}
                                                {{ $payment->contract->employee->name }}
                                            </td>
                                            <td class="text-nowrap text-break">
                                                <span title="{{ $payment->contract->budgetary_objective->name }}"
                                                    class="d-inline-block text-truncate" style="max-width: 250px;">
                                                    {{ $payment->contract->budgetary_objective->name }}
                                                </span>
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'basic', this.value)"
                                                    value="{{ $payment->basic }}" step="0.01">
                                            </td>
                                            <td>
                                                <input class="form-control"
                                                    type="number"value="{{ $payment->net_pay }}" disabled>
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'days', this.value)"
                                                    value="{{ $payment->days }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'days_discount', this.value)"
                                                    value="{{ $payment->days_discount }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'hours_discount', this.value)"
                                                    value="{{ $payment->hours_discount }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'minutes_discount', this.value)"
                                                    value="{{ $payment->minutes_discount }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'refound', this.value)"
                                                    value="{{ $payment->refound }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number"
                                                    onchange="changeValuePayment({{ $payment->id }}, 'aguinaldo', this.value)"
                                                    value="{{ $payment->aguinaldo }}"
                                                    {{ $payment->period->mounth === 7 || $payment->period->mounth === 12 ? '' : 'disabled' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <button id="btnCalculate" wire:target="calculate"
                                            wire:loading.class='disabled' type="button"
                                            class="mt-1 font-weight-bold btn btn-info w-100 h-100" onclick='calculate()'>
                                            <div wire:target="calculate" wire:loading.class='d-inline-block'
                                                class="d-none spinner-border spinner-border-sm" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <i class="fas fa-calculator"></i> REALIZAR CALCULOS
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <button type="button" data-toggle="modal" data-target="#modalMcpp"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100"
                                            wire:click='prepare_mcpp'>
                                            <i class="fas fa-file-alt"></i> INTERFAZ MCPP
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <a href="{{ route('payrolls.generate_payment_slips_period', $selected_period) }}"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100" target="_blank">
                                            <i class="fas fa-file-pdf"></i> IMPRIMIR BOLETAS
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <a href="{{ route('payrolls.general_report', $selected_period) }}"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100" target="_blank">
                                            <i class="fas fa-file-pdf"></i> REPORTE GENERAL
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <a href="{{ route('payrolls.payroll_report', $selected_period) }}"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100" target="_blank">
                                            <i class="fas fa-file-pdf"></i> IMPRIMIR PLANILLA
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <a href="{{ route('payrolls.payroll_summary', $selected_period) }}"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100" target="_blank">
                                            <i class="fas fa-file-pdf"></i> RESUMEN DE PLANILLA
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <button type="button" data-toggle="modal" data-target="#modalAfpNet"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100"
                                            wire:click='prepare_afp_net'>
                                            <i class="fas fa-file-excel"></i> AFP NET
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <button type="button" data-toggle="modal" data-target="#modalJor"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100"
                                            wire:click='prepare_jor'>
                                            <i class="fas fa-file-alt"></i> JOR
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-xl-3 mb-2 text-nowrap">
                                        <button type="button" data-toggle="modal" data-target="#modalRem"
                                            class="mt-1 font-weight-bold btn btn-secondary w-100 h-100"
                                            wire:click='prepare_rem'>
                                            <i class="fas fa-file-alt"></i> REM
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <span>Todavía no hay empleados asignados</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#modal_employee_id').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalEmployee')
            }).on('select2:select', function(e) {
                // @this.set('modal_employee_id', $('#modal_employee_id').select2("val"));
                @this.searchContracts($('#modal_employee_id').select2("val"));
            });

            $('#modal_group_id').on('change', function() {
                @this.searchContractsGroup($(this).val());
            });
        });

        function searchContracts() {
            @this.searchContracts($('#modal_employee_id').select2("val"));
        }

        function searchContractsGroup() {
            @this.searchContractsGroup($("#modal_group_id").val());
        }

        function deleteContract(id) {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Tendrás que volver a insertar al empleado si lo quitas",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Quitar!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deleteContract(id);
                }
            })
        }

        function deletePeriod() {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Toda la información de este periodo se perderá",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deletePeriod();
                }
            })
        }

        function changeValuePayment(payment_id, field, value) {
            if (value === "") {
                value = null;
            }
            @this.changeValuePayment(payment_id, field, value);
        }

        function changeValueAfp(index, row, value) {
            if (value === "") {
                value = null;
            }
            @this.changeValueAfp(index, row, value);
        }

        function changeValueJor(index, row, value) {
            if (value === "") {
                value = null;
            }
            @this.changeValueJor(index, row, value);
        }

        function calculate() {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Se realizaran los cálculos con los datos actuales",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Calcular!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.calculate();
                }
            })
        }
    </script>
@endpush
