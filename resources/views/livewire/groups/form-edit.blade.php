<div>
    <form wire:submit='save'>
        <div class="card">
            <div class="card-header font-weight-bold">
                DATOS GENERALES
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre del grupo*:</label>
                            <input type="text" wire:model='name' id="name" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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

    <div class="card">
        <div class="card-header font-weight-bold">
            AGREGAR EMPLEADOS
        </div>
        <div class="card-body">
            <form wire:submit="addEmployee">
                <div class="row">
                    <div class="col-md-9">
                        <div wire:ignore class="mt-1 form-group">
                            <select id="employee_id" class="form-control select2"
                                data-placeholder="Seleccione al empleado" required>
                                <option></option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">[{{ $employee->identity_number }}]
                                        {{ $employee->last_name }} {{ $employee->second_last_name }}
                                        {{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button wire:loading.attr='disabled'
                            class="mt-1 w-100 btn btn-success font-weight-bold">AGREGAR</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                @if (count($employees_group) > 0)
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">IDENTIFICACIÓN</th>
                                <th scope="col">EMPLEADO</th>
                                <th scope="col" class="text-right">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees_group as $index => $employee)
                                <tr wire:key='{{ $employee->id }}'>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>[{{ $employee->identity_type }}] {{ $employee->identity_number }}</td>
                                    <td class="text-nowrap">{{ $employee->last_name }}
                                        {{ $employee->second_last_name }}
                                        {{ $employee->name }}
                                    </td>
                                    <td class="text-right">
                                        <button onclick="removeEmployee({{ $employee->id }})"
                                            class="text-nowrap font-weight-bold btn btn-danger btn-sm"><i
                                                class="fas fa-trash-alt"></i>
                                            QUITAR
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">Ningún empleado asignado</div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('#employee_id').select2({
                theme: 'bootstrap4',
            }).on('select2:select', function(e) {
                @this.set('employee_id', $('#employee_id').select2("val"));
            });
        });

        function removeEmployee(id) {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Tendrás que volver a insertar al empleado si lo quitas",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, QUITAR',
                cancelButtonText: 'NO'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.removeEmployee(id);
                }
            })
        }
    </script>
@endpush
