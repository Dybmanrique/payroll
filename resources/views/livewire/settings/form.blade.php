<div class="pb-3">
    <form wire:submit='save'>
        <div class="card">
            <div class="card-header font-weight-bold">
                DATOS DE LA INSTITUCIÓN
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="institution_name">Nombre*:</label>
                            <input type="text" wire:model='institution_name' id="institution_name"
                                class="form-control" placeholder="Ingrese el código la fuente de financiamiento"
                                required autocomplete="off">
                            @error('institution_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ruc">RUC*:</label>
                            <input type="number" wire:model='ruc' id="ruc" class="form-control"
                                placeholder="Ingrese el código la fuente de financiamiento" required autocomplete="off">
                            @error('ruc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="airhsp_code">Código unidad ejecutora AIRHSP*:</label>
                            <input type="number" wire:model='airhsp_code' id="airhsp_code" class="form-control"
                                placeholder="Ingrese el código la fuente de financiamiento" required autocomplete="off">
                            @error('airhsp_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header font-weight-bold">
                PARÁMETROS
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="uit">UIT*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">S/.</span>
                                </div>
                                <input type="number" id="uit" wire:model='uit' class="form-control"
                                    placeholder="Aportación obligatoria" required>
                            </div>
                            @error('uit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="max_amount_essalud_percent">Base máxima imponible Essalud*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" id="max_amount_essalud_percent"
                                    wire:model='max_amount_essalud_percent' class="form-control"
                                    placeholder="Aportación obligatoria" min="1" max="100" step="0.01"
                                    required>
                            </div>
                            @error('max_amount_essalud_percent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="essalud_percent">Comisión ESSALUD*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" id="essalud_percent" wire:model='essalud_percent'
                                    class="form-control" placeholder="Aportación obligatoria" min="1"
                                    max="100" step="0.01" required>
                            </div>
                            @error('essalud_percent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="onp_percent">Comisión ONP*:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" id="onp_percent" wire:model='onp_percent' class="form-control"
                                    placeholder="Aportación obligatoria" min="1" max="100" step="0.01"
                                    required>
                            </div>
                            @error('onp_percent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="working_hours">Horas laborables*:</label>
                            <input type="number" step="0.1" wire:model='working_hours' id="working_hours"
                                class="form-control" placeholder="Ingrese el código la fuente de financiamiento"
                                required autocomplete="off">
                            @error('working_hours')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('settings.edit')
            <button id="back-to-top" class="btn btn-primary back-to-top font-weight-bold" type="submit"
                aria-label="Scroll to top">
                <i class="fas fa-save"></i> GUARDAR
            </button>
        @endcan
    </form>
</div>
