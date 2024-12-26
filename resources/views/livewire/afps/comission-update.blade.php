<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="automaticModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR COMISIONES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div wire:loading.class='d-block' class="d-none" wire:target='getComissions'>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border" role="status">
                              <span class="sr-only">Loading...</span>
                            </div>
                            <span class="font-weight-bold ml-2"> CARGANDO...</span>
                        </div>
                    </div>

                    <div wire:loading.class='d-none' wire:target='getComissions'>
                        @if ($comissions_result)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">C. VARIABLE</th>
                                            <th scope="col">S. DE VIDA</th>
                                            <th scope="col">A. OBLIGATORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comissions_result as $afp)
                                            <tr>
                                                <th scope="row">{{ $afp['AFP'] ?? 'No datos' }}</th>
                                                <td>{{ $afp['commission_on_flow'] ?? 'No datos' }}</td>
                                                <td>{{ $afp['insurance_premium'] ?? 'No datos' }}</td>
                                                <td>{{ $afp['mandatory_contribution'] ?? 'No datos' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <form wire:submit='updateComissionsAutomatic'>
                                    <button wire:target='viewComissions' wire:loading.attr='disabled' type="submit"
                                        class="btn btn-primary w-100">ACTUALIZAR COMISIONES</button>
                                </form>
                            </div>
                        @else
                            <div class="text-center">NO SE ENCONTRARON COMISIONES</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="manualModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR COMISIONES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form wire:submit='viewComissions'>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="source_code">Código fuente*: </label>
                                            <textarea wire:model="source_code" id="source_code" class="form-control" rows="2"></textarea>
                                            @error('source_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <a class="link" target="_blank"
                                                    href="https://www.sbs.gob.pe/app/spp/empleadores/comisiones_spp/paginas/comision_prima.aspx">Página
                                                    de comisiones</a>
                                                <button type="button" class="btn text-lg p-0" data-toggle="popover"
                                                    title="Ayuda"
                                                    data-content="Dirigete al link de comisiones, abre el código fuente de la página (Ctrl + U), selecciona todo (Ctrl + A), copia y pega el texto en el cuadro de arriba. Después haga click en el botón de buscar datos y si todo está correcto, podrá actualizar las comisiones"><i
                                                        class="fas fa-info-circle"></i></button>
                                            </div>
                                            <button type="submit" class="btn btn-secondary">BUSCAR DATOS</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" wire:target='viewComissions' wire:loading.class="opacity-20"
                                    style="display: relative; transition-property: opacity; transition-duration: 700ms;">
                                    @if ($afps_list)
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">NOMBRE</th>
                                                        <th scope="col">C. VARIABLE</th>
                                                        <th scope="col">S. DE VIDA</th>
                                                        <th scope="col">A. OBLIGATORIO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($afps_list as $afp)
                                                        <tr>
                                                            <th scope="row">{{ $afp[0] ?? 'No datos' }}</th>
                                                            <td>{{ $afp[1] ?? 'No datos' }}</td>
                                                            <td>{{ $afp[3] ?? 'No datos' }}</td>
                                                            <td>{{ $afp[4] ?? 'No datos' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <form wire:submit='updateComissions'>
                                                <button wire:target='viewComissions' wire:loading.attr='disabled'
                                                    type="submit" class="btn btn-primary w-100">ACTUALIZAR
                                                    COMISIONES</button>
                                            </form>
                                        </div>
                                    @else
                                        <span>Aquí apareceran las comisiones</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <button type="button" class="btn btn-success text-uppercase font-weight-bold" data-toggle="modal"
        data-target="#automaticModal" wire:click='getComissions'>Actualizar automáticamente</button>

    <button type="button" class="btn btn-info text-uppercase font-weight-bold" data-toggle="modal"
        data-target="#manualModal">Actualizar manualmente</button>
</div>
@push('js')
    <script>
        $(function() {
            $('[data-toggle="popover"]').popover()
        })
    </script>
@endpush
