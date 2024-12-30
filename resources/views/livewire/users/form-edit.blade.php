<div>
    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre*:</label>
                            <input wire:model='name' type="text" id="name" class="form-control"
                                placeholder="Ingrese el nombre de usuario" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email*:</label>
                            <input wire:model='email' type="email" id="email" class="form-control"
                                placeholder="Ingrese el correo electrónico del usuario" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <p class="text-bold mb-1">Roles:</p>
                        <div class="form-group border p-2 mb-2 rounded">
                            @foreach ($roles as $role)
                                <div class="form-check form-switch">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" wire:model='user_roles'
                                            value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div> --}}

                        <button class="btn btn-info mt-2 mb-2" type="button" data-toggle="collapse"
                            data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Cambiar contraseña <i class="fas fa-key"></i>
                        </button>

                        <div wire:ignore.self class="collapse mt-0" id="collapseExample">
                            <div class="card card-body border shadow-none">
                                <div class="form-group">
                                    <label for="password">Password*:</label>
                                    <input wire:model='password' type="password" id="password" class="form-control"
                                        placeholder="Ingrese una contraseña">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar password*:</label>
                                    <input wire:model='password_confirmation' type="password" id="password_confirmation"
                                        class="form-control" placeholder="Repita la contraseña">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
