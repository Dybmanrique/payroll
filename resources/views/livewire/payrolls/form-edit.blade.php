<div class="pb-3">
    <!-- Modal Add Period -->
    <div wire:ignore.self class="modal fade" id="modalPeriod" tabindex="-1" role="dialog"
        aria-labelledby="modalPeriodLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit='addPeriod'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPeriodLabel">AGREGAR PERIODO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modal_period_id">Lista de periodos*:</label>
                            <select wire:model="modal_period_id" id="modal_period_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($periods as $index => $period)
                                    <option value="{{ $index }}">{{ $period }}</option>
                                @endforeach
                            </select>
                            @error('modal_period_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">ACEPTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add Employee -->
    <div wire:ignore class="modal fade" id="modalEmployee" tabindex="-1" role="dialog"
        aria-labelledby="modalEmployeeLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit='addEmployee'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEmployeeLabel">AGREGAR EMPLEADO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modal_employee_id">Lista de empleados*:</label>
                            <select id="modal_employee_id" class="form-control select2"
                                data-placeholder="Seleccione al empleado" required>
                                <option></option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">[{{ $employee->dni }}]
                                        {{ $employee->last_name }} {{ $employee->second_last_name }}
                                        {{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('modal_employee_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'>ACEPTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add Group -->
    <div wire:ignore.self class="modal fade" id="modalGroup" tabindex="-1" role="dialog"
        aria-labelledby="modalGroupLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit='addGroup'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalGroupLabel">AGREGAR POR GRUPO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modal_group_id">Lista de grupos*:</label>
                            <select wire:model="modal_group_id" id="modal_group_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            @error('modal_group_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">ACEPTAR</button>
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
                            <button type="submit" class="btn btn-info font-weight-bold"><i class="fas fa-search"></i> BUSCAR</button>
                        </div>
                        <select id="selected_period" wire:model="selected_period" class="form-control" required>
                            <option value="">--Seleccione un periodo--</option>
                            @foreach ($periods_payroll as $period)
                                <option value="{{ $period->id }}" wire:key='{{ $period->id }}'>{{ $periods[$period->mounth] }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button type="button" onclick='deletePeriod()' wire:loading.attr='disabled' wire:target='deletePeriod' class="btn btn-danger font-weight-bold rounded-right"><i class="fas fa-trash-alt"></i> ELIMINAR</button>
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
    <div wire:loading.class='opacity-low' wire:target="searchEmployees"
        style="transition-property: opacity; transition-duration: 300ms;">
        @if ($payments_list)
            <div class="card" wire:loading.remove wire:target="searchEmployees">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="font-weight-bold">LISTA DE EMPLEADOS</span>
                        <div>
                            <button class="btn btn-secondary btn-sm font-weight-bold" type="button"
                                data-toggle="modal" data-target="#modalEmployee">AGREGAR</button>
                            <button class="btn btn-dark btn-sm font-weight-bold" type="button" data-toggle="modal"
                                data-target="#modalGroup">AGREGAR VARIOS</button>
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
                                        <th scope="col">DNI</th>
                                        <th scope="col">EMPLEADO</th>
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
                                                <button onclick='deleteEmployee({{ $payment->id }})' type="button"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                    ELIMINAR
                                                </button>
                                            </td>
                                            <td>{{ $payment->employee->dni }}</td>
                                            <td class="text-nowrap">{{ $payment->employee->last_name }}
                                                {{ $payment->employee->second_last_name }}
                                                {{ $payment->employee->name }}
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
                                                    value="{{ $payment->aguinaldo }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <button id="btnCalculate" wire:target="calculate"
                                            wire:loading.class='disabled' type="button"
                                            class="font-weight-bold btn btn-info w-100" onclick='calculate()'>
                                            <div wire:target="calculate" wire:loading.class='d-inline-block'
                                                class="d-none spinner-border spinner-border-sm" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <i class="fas fa-calculator"></i> REALIZAR CALCULOS
                                        </button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="font-weight-bold btn btn-info w-100"
                                            wire:click='mcpp()'><i class="fas fa-file-alt"></i> INTERFAZ MCPP</button>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('payrolls.generate_payment_slips_period', $selected_period) }}"
                                            class="font-weight-bold btn btn-secondary w-100" target="_blank">
                                            <i class="fas fa-file-pdf"></i> IMPRIMIR BOLETAS
                                        </a>
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
                @this.set('modal_employee_id', $('#modal_employee_id').select2("val"));
            });
        });

        function deleteEmployee(id) {
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
                    @this.deleteEmployee(id);
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
