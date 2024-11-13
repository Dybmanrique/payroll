<div class="pb-2">
    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nombre Actividad*:</label>
                            <textarea class="form-control" wire:model='name' id="name" rows="2" placeholder="Nombre de la finalidad" required></textarea>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="programa_pptal">Programa presupuestal*:</label>
                            <input type="text" wire:model='programa_pptal' id="programa_pptal" class="form-control"
                                placeholder="Código de la categoría presupuestal" required autocomplete="off">
                            @error('programa_pptal')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="producto_proyecto">Producto/Proyecto*:</label>
                            <input type="text" wire:model='producto_proyecto' id="producto_proyecto"
                                class="form-control" placeholder="Código del producto o proyecto" required autocomplete="off">
                            @error('producto_proyecto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activ_obra_accinv">Actividad/Obra/Inversión/Obra*:</label>
                            <input type="text" wire:model='activ_obra_accinv' id="activ_obra_accinv"
                                class="form-control" placeholder="Código de la actividad, acción de inversión u obra" required autocomplete="off">
                            @error('activ_obra_accinv')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="funcion">Función*:</label>
                            <input type="text" wire:model='funcion' id="funcion" class="form-control"
                                placeholder="Código de la Función" required autocomplete="off">
                            @error('funcion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="division_fn">División función*:</label>
                            <input type="text" wire:model='division_fn' id="division_fn" class="form-control"
                                placeholder="Código de División Funcional" required autocomplete="off">
                            @error('division_fn')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="grupo_fn">Grupo función*:</label>
                            <input type="text" wire:model='grupo_fn' id="grupo_fn" class="form-control"
                                placeholder="Código del Grupo Funcional." required autocomplete="off">
                            @error('grupo_fn')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sec_func">Secuencia funcional*:</label>
                            <input type="text" wire:model='sec_func' id="sec_func" class="form-control"
                                placeholder="Número secuencial de las metas que tiene la Unidad Ejecutora" required autocomplete="off">
                            @error('sec_func')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cas_classifier">Clasificador CAS*:</label>
                            <input type="text" wire:model='cas_classifier' id="cas_classifier" class="form-control"
                                placeholder="Clasificador CAS" autocomplete="off">
                            @error('cas_classifier')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="essalud_classifier">Clasificador Essalud*:</label>
                            <input type="text" wire:model='essalud_classifier' id="essalud_classifier"
                                class="form-control" placeholder="Clasificador Essalud" autocomplete="off">
                            @error('essalud_classifier')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aguinaldo_classifier">Clasificador Aguinaldo*:</label>
                            <input type="text" wire:model='aguinaldo_classifier' id="aguinaldo_classifier"
                                class="form-control" placeholder="Clasificador aguinaldo" autocomplete="off">
                            @error('aguinaldo_classifier')
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
