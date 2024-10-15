<div>
    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pneumonic">Neumonico*:</label>
                            <input type="text" wire:model='pneumonic' id="pneumonic" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('pneumonic')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="function">Función*:</label>
                            <input type="text" wire:model='function' id="function" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('function')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="program">Programa*:</label>
                            <input type="text" wire:model='program' id="program" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('program')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subprogram">Sub Programa*:</label>
                            <input type="text" wire:model='subprogram' id="subprogram" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('subprogram')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="program_p">Programa P.*:</label>
                            <input type="text" wire:model='program_p' id="program_p" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('program_p')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="act_proy">Act/Proy*:</label>
                            <input type="text" wire:model='act_proy' id="act_proy" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('act_proy')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="component">Componente*:</label>
                            <input type="text" wire:model='component' id="component" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('component')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cas_classifier">Clasificador CAS*:</label>
                            <input type="text" wire:model='cas_classifier' id="cas_classifier" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('cas_classifier')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="essalud_classifier">Clasificador Essalud*:</label>
                            <input type="text" wire:model='essalud_classifier' id="essalud_classifier" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
                            @error('essalud_classifier')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">N. Actividad*:</label>
                            <input type="text" wire:model='name' id="name" class="form-control"
                                placeholder="Ingrese el nombre" required autocomplete="off">
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
</div>
