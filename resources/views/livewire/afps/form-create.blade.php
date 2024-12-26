<div>
    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre del AFP*:</label>
                            <input type="text" wire:model='name' id="name" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="obligatory_contribution">Aportación obligatoria*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" id="obligatory_contribution" wire:model='obligatory_contribution'
                                    class="form-control" placeholder="Aportación obligatoria" min="0"
                                    max="100" step="0.01" required>
                            </div>
                            @error('obligatory_contribution')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="life_insurance">Seguro de vida*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" id="life_insurance" wire:model='life_insurance'
                                    class="form-control" placeholder="Aportación obligatoria" min="0"
                                    max="100" step="0.01" required>
                            </div>
                            @error('life_insurance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="variable_commission">Comisión de variable*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" id="variable_commission" wire:model='variable_commission'
                                    class="form-control" placeholder="Aportación obligatoria" min="0"
                                    max="100" step="0.01" required>
                            </div>
                            @error('variable_commission')
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
</div>
