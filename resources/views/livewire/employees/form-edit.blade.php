<div>
    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dni">DNI*:</label>
                            <input type="number" wire:model='dni' id="dni" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('dni')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                                    <input class="form-check-input" type="radio" wire:model="gender" id="inlineRadio1"
                                        value="Masculino">
                                    <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="gender" id="inlineRadio2"
                                        value="Femenino">
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
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                            @error('airhsp_code')
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
                            <input type="date" wire:model='start_validity' id="start_validity" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
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
                            <label for="ruc">RUC*:</label>
                            <input type="number" wire:model='ruc' id="ruc" class="form-control"
                                placeholder="Ingrese el nombre del grupo" required autocomplete="off">
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
                            <span class="d-block w-100 font-weight-bold mb-2">Sistema de pensiones*:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <input type="radio" name="pension_system" wire:model='pension_system'
                                        id="option_a2" value="afp" autocomplete="off"> AFP
                                </label>
                                <label class="btn btn-info">
                                    <input type="radio" name="pension_system" wire:model='pension_system'
                                        id="option_a3" value="onp" autocomplete="off"> ONP
                                </label>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Contenido extra a mostrar -->
                        <div class="border rounded p-2" id="contenidoExtraAfp" style='{{ ($onp) ? 'display: none;' : '' }}'>
                            {{-- <div class="form-group">
                                <label for="name">Tipo AFP*:</label>
                                <input type="text" wire:model='name' id="name" class="form-control"
                                    placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Código AFP*:</label>
                                <input type="text" wire:model='name' id="name" class="form-control"
                                    placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">AFP fing*:</label>
                                <input type="text" wire:model='name' id="name" class="form-control"
                                    placeholder="Ingrese el nombre del grupo" required autocomplete="off">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            xd
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
@push('js')
    <script>
        $(document).ready(function() {
            // Detectar cambio en los radio buttons
            $('input[type=radio][name=pension_system]').change(function() {
                // Ocultar todo el contenido extra al cambiar de selección
                $('#contenidoExtraAfp').slideUp();

                // Mostrar el contenido según el radio button seleccionado
                if (this.value == 'afp') {
                    $('#contenidoExtraAfp').slideDown();
                }
            });
        });
    </script>
@endpush
