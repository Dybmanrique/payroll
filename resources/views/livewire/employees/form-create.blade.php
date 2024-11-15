<div class="pb-2">
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
                                placeholder="Ingrese el nombre del grupo" autocomplete="off">
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
                            <label for="ruc">RUC:</label>
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
                    <div class="col-md-12">
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
                            style='display: none;'>
                            <div class="row">
                                <div class="col-md-4">
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
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="afp_code">Código AFP*:</label>
                                        <input type="text" wire:model='afp_code' id="afp_code" class="form-control"
                                            placeholder="Ingrese el nombre del grupo" autocomplete="off">
                                        @error('afp_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
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
            $('.pension-system').change(function() {
                $('#contenidoExtraAfp').slideUp();

                if (this.value == 'afp') {
                    $('#contenidoExtraAfp').slideDown();
                }
            });
        });

        Livewire.on('hide_afp', function() {
            $('#contenidoExtraAfp').slideUp();
        })
    </script>
@endpush
