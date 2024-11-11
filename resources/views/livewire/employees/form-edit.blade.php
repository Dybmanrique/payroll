<div class="pb-3">
    <!-- Modal add Judicial Discount-->
    <div wire:ignore.self class="modal fade" id="judicialModal" tabindex="-1" aria-labelledby="judicialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit='addJudicialDiscount()'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="judicialModalLabel">DESCUENTO JUDICIAL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div wire:loading.remove wire:target='enableJudicialEdition'>

                            <div class="form-group">
                                <label for="judicial_name">Nombre judicial*:</label>
                                <input type="text" class="form-control" id="judicial_name" wire:model='judicial_name'
                                    required>
                                @error('judicial_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="judicial_amount">Descuento*:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select id="judicial_discount_type" wire:model="judicial_discount_type"
                                            class="form-control" required>
                                            <option value="">--Seleccione--</option>
                                            <option value="fijo">FIJO</option>
                                            <option value="porcentaje_total">% TOTAL</option>
                                        </select>
                                    </div>
                                    <input type="number" wire:model='judicial_amount' id="judicial_amount"
                                        class="form-control" required autocomplete="off">
                                    @error('judicial_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="judicial_account">Cuenta Judicial*:</label>
                                <input type="number" class="form-control" id="judicial_account"
                                    wire:model='judicial_account'>
                                @error('judicial_account')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="judicial_dni">DNI judicial*:</label>
                                <input type="number" class="form-control" id="judicial_dni" wire:model='judicial_dni'>
                                @error('judicial_dni')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center w-100" wire:loading wire:target='enableJudicialEdition'>
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            CARGANDO...
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
            <div class="card-header font-weight-bold">
                DATOS GENERALES
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="identity_number">Número de identificación*:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select id="identity_type_id" wire:model="identity_type_id" class="form-control"
                                        required>
                                        @foreach ($identity_types as $identity_type)
                                            <option value="{{ $identity_type->id }}">{{ $identity_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" wire:model='identity_number' id="identity_number"
                                    class="form-control" placeholder="Ingrese el nombre del grupo" required
                                    autocomplete="off">
                                @error('identity_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombres*:</label>
                            <input type="text" wire:model='name' id="name" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Apellido Paterno*:</label>
                            <input type="text" wire:model='last_name' id="last_name" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="second_last_name">Apellido Materno*:</label>
                            <input type="text" wire:model='second_last_name' id="second_last_name"
                                class="form-control" placeholder="Ingrese el nombre del grupo" required
                                autocomplete="off">
                            @error('second_last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender" class="w-100">Género*:</label>
                            <div class="rounded p-2" style="max-height: 38px; border: 1px solid #ced4da;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="gender"
                                        id="inlineRadio1" value="Masculino">
                                    <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="gender"
                                        id="inlineRadio2" value="Femenino">
                                    <label class="form-check-label" for="inlineRadio2">Femenino</label>
                                </div>
                            </div>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate">Nacimiento*:</label>
                            <input type="date" wire:model='birthdate' id="birthdate" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('birthdate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="airhsp_code">Código AIRHSP:</label>
                            <input type="text" wire:model='airhsp_code' id="airhsp_code" class="form-control"
                                placeholder="Ingrese el nombre del grupo" autocomplete="off">
                            @error('airhsp_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remuneration">Remuneración:</label>
                            <input type="number" wire:model='remuneration' id="remuneration" class="form-control"
                                placeholder="Ingrese el nombre del grupo" step="0.01" required autocomplete="off">
                            @error('remuneration')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_entry">Fecha de ingreso*:</label>
                            <input type="date" wire:model='date_entry' id="date_entry" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('date_entry')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_validity">Inicio de vigencia*:</label>
                            <input type="date" wire:model='start_validity' id="start_validity"
                                class="form-control" placeholder="Ingrese el nombre del grupo" required
                                autocomplete="off">
                            @error('start_validity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_validity">Fin de vigencia*:</label>
                            <input type="date" wire:model='end_validity' id="end_validity" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('end_validity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_account">Cuenta bancaria*:</label>
                            <input type="text" wire:model='bank_account' id="bank_account" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('bank_account')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="working_hours">Jornada laboral*:</label>
                            <input type="number" wire:model='working_hours' id="working_hours" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('working_hours')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Seguro de vida*:</label>
                            <div class="rounded p-2" style="max-height: 38px; border: 1px solid #ced4da;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="essalud"
                                        wire:model='essalud'>
                                    <label class="form-check-label" for="essalud">
                                        Tiene Essalud
                                    </label>
                                </div>
                            </div>
                            @error('essalud')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Renta*:</label>
                            <div class="rounded p-2" style="max-height: 38px; border: 1px solid #ced4da;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cuarta"
                                        wire:model='cuarta'>
                                    <label class="form-check-label" for="cuarta">
                                        Renta de 4ta categoría
                                    </label>
                                </div>
                            </div>
                            @error('cuarta')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ruc">RUC*:</label>
                            <input type="number" wire:model='ruc' id="ruc" class="form-control"
                                placeholder="Ingrese el nombre del grupo" autocomplete="off">
                            @error('ruc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="group_id">Grupo*:</label>
                            <select wire:model="group_id" id="group_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            @error('group_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_position_id">Cargo*:</label>
                            <select wire:model="job_position_id" id="job_position_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($job_positions as $job_position)
                                    <option value="{{ $job_position->id }}">{{ $job_position->name }}</option>
                                @endforeach
                            </select>
                            @error('job_position_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="level_id">Nivel*:</label>
                            <select wire:model="level_id" id="level_id" class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="budgetary_objective_id">Meta presupuestal*:</label>
                            <select wire:model="budgetary_objective_id" id="budgetary_objective_id"
                                class="form-control" required>
                                <option value="">--Seleccione--</option>
                                @foreach ($budgetary_objectives as $budgetary_objective)
                                    <option value="{{ $budgetary_objective->id }}">
                                        [{{ $budgetary_objective->pneumonic }}] {{ $budgetary_objective->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('budgetary_objective_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <span class="d-block w-100 font-weight-bold mb-2">Sistema de pensiones*:</span>
                            <div class="rounded p-2" style="max-height: 38px; border: 1px solid #ced4da;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pension-system" type="radio"
                                        wire:model="pension_system" id="afp_radio" value="afp">
                                    <label class="form-check-label" for="afp_radio">AFP</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pension-system" type="radio"
                                        wire:model="pension_system" id="onp_radio" value="onp">
                                    <label class="form-check-label" for="onp_radio">ONP</label>
                                </div>
                            </div>
                            @error('pension_system')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Contenido extra a mostrar -->
                        <div wire:ignore.self class="border rounded p-2" id="contenidoExtraAfp"
                            style='{{ $pension_system === 'onp' ? 'display: none;' : '' }}'>
                            <div class="form-group">
                                <label for="afp_id">Tipo AFP*:</label>
                                <select wire:model="afp_id" id="afp_id" class="form-control">
                                    <option value="">--Seleccione--</option>
                                    @foreach ($afps as $afp)
                                        <option value="{{ $afp->id }}">{{ $afp->name }}</option>
                                    @endforeach
                                </select>
                                @error('afp_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="afp_code">Código AFP*:</label>
                                <input type="text" wire:model='afp_code' id="afp_code" class="form-control"
                                    placeholder="Ingrese el nombre del grupo" autocomplete="off">
                                @error('afp_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="afp_fing">AFP fing*:</label>
                                <input type="date" wire:model='afp_fing' id="afp_fing" class="form-control"
                                    placeholder="Ingrese el nombre del grupo">
                                @error('afp_fing')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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

    <div class="card">
        <div class="card-header font-weight-bold">
            <div class="d-flex justify-content-between align-items-center">
                <span>DESCUENTOS JUDICIALES</span>
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                    data-target="#judicialModal">AGREGAR</button>
            </div>
        </div>
        <div class="card-body">
            @forelse ($judicial_discounts as $judicial_discount)
                <div class="rounded border mb-2 p-2 d-flex justify-content-between align-items-center"
                    wire:key='{{ $judicial_discount->id }}'>
                    <div class="w-100">
                        <div><span class="font-weight-bold">NOMBRE:</span> {{ $judicial_discount->name }}</div>
                        <div class="row">
                            <div class="col-md-4"><span class="font-weight-bold">DESCUENTO:</span>
                                {{ $judicial_discount->amount }}
                                (@php
                                    if ($judicial_discount->discount_type == 'fijo') {
                                        echo 'FIJO';
                                    }
                                    if ($judicial_discount->discount_type == 'porcentaje_total') {
                                        echo '% TOTAL';
                                    }
                                @endphp)
                            </div>
                            <div class="col-md-4"><span class="font-weight-bold">CUENTA JUDICIAL:</span>
                                {{ $judicial_discount->account ?? 'No tiene' }}</div>
                            <div class="col-md-4"><span class="font-weight-bold">DNI JUDICIAL:</span>
                                {{ $judicial_discount->dni ?? 'No tiene' }}</div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-sm mb-1 w-100" data-toggle="modal"
                            data-target="#judicialModal"
                            wire:click='enableJudicialEdition({{ $judicial_discount->id }})'>
                            <i class="fas fa-edit"></i> EDITAR
                        </button>
                        <button class="btn btn-danger btn-sm w-100" type="button" onclick="deleteJudicial({{ $judicial_discount->id }})"><i class="fas fa-trash-alt"></i>
                            ELIMINAR</button>
                    </div>
                </div>
            @empty
                <div class="text-center">No tiene</div>
            @endforelse
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            // Detectar cambio en los radio buttons
            $('.pension-system').change(function() {
                // Ocultar todo el contenido extra al cambiar de selección
                $('#contenidoExtraAfp').slideUp();

                // Mostrar el contenido según el radio button seleccionado
                if (this.value == 'afp') {
                    $('#contenidoExtraAfp').slideDown();
                }
            });

            $('#judicialModal').on('hidden.bs.modal', function(e) {
                // Código a ejecutar cuando el modal se cierra
                @this.set('judicial_edit_mode', false);
                @this.set('judicial_name', null);
                @this.set('judicial_amount', null);
                @this.set('judicial_discount_type', null);
                @this.set('judicial_account', null);
                @this.set('judicial_dni', null);
            });
        });

        function deleteJudicial(id){
            Swal.fire({
                    title: 'Estas seguro?',
                    text: "Esta acción se aplicará directamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1e40af',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SÍ, ELIMINAR!',
                    cancelButtonText: 'CANCELAR'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.deleteJudicial(id);
                    }
                })
        }
    </script>
@endpush
