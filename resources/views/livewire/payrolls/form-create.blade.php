<div class="py-3">
    <form wire:submit='save'>
        <div class="card m-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <span class="font-weight-bold">DATOS DE LA PLANILLA</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="number">Número*:</label>
                                    <input type="text" wire:model='number' id="number" class="form-control"
                                        placeholder="Ingrese el número" required autocomplete="off">
                                    @error('number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="year">Año*:</label>
                                    <input type="number" wire:model='year' id="year" class="form-control"
                                        placeholder="Ingrese el número" required autocomplete="off">
                                    @error('year')
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right font-weight-bold text-uppercase"><i
                                    class="fas fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                    </div>
                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </form>
</div>
