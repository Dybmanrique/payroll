<div>
    <!-- Modal Add Employee -->
    <div wire:ignore.self class="modal fade" id="modalEmployee" tabindex="-1" role="dialog"
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
                            <select wire:model="modal_employee_id" id="modal_employee_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
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
                        <button type="submit" class="btn btn-primary">ACEPTAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="number">Número*:</label>
                            <input type="text" wire:model='number' id="number" class="form-control"
                                placeholder="Ingrese el número" required autocomplete="off">
                            @error('number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="period">Periodo*:</label>
                            <input type="text" wire:model='period' id="period" class="form-control"
                                placeholder="Ingrese el número" required autocomplete="off">
                            @error('period')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="processing_date">Fecha de proceso*:</label>
                            <input type="date" wire:model='processing_date' id="processing_date" class="form-control"
                                placeholder="Ingrese el número" required autocomplete="off">
                            @error('processing_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="payroll_type_id">Tipo de planilla*:</label>
                            <select wire:model="payroll_type_id" id="payroll_type_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($payroll_types as $payroll_type)
                                    <option value="{{ $payroll_type->id }}">{{ $payroll_type->name }}</option>
                                @endforeach
                            </select>
                            @error('payroll_type_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="funding_resource_id">Fuente de financiamiento*:</label>
                            <select wire:model="funding_resource_id" id="funding_resource_id" class="form-control"
                                required>
                                <option value="">--Seleccione--</option>
                                @foreach ($funding_resources as $funding_resource)
                                    <option value="{{ $funding_resource->id }}">[{{ $funding_resource->code }}]
                                        {{ $funding_resource->name }}</option>
                                @endforeach
                            </select>
                            @error('funding_resource_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <span class="font-weight-bold">LISTA DE EMPLEADOS</span>
                                    <div>
                                        <button class="btn btn-secondary btn-sm font-weight-bold" type="button"
                                            data-toggle="modal" data-target="#modalEmployee">AGREGAR</button>
                                        <button class="btn btn-dark btn-sm font-weight-bold">AGREGAR VARIOS</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($employees_list)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">DNI</th>
                                                    <th scope="col">Empleado</th>
                                                    <th scope="col">Monto</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($employees_list as $index => $employee)
                                                    <tr>
                                                        <th scope="row">{{ $index + 1 }}</th>
                                                        <td>{{ $employee->dni }}</td>
                                                        <td>{{ $employee->last_name }} {{ $employee->second_last_name }} {{ $employee->name }}</td>
                                                        <td>1000.00</td>
                                                        <td>Botones</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    No hay
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right font-weight-bold text-uppercase"><i
                        class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>
