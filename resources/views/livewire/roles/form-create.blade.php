<div class="pb-2">
    <form wire:submit='save'>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nombre*:</label>
                    <input type="text" wire:model='name' class="form-control" placeholder="Ingrese el nombre del rol"
                        required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <table class="table">
                    <tr>
                        <th colspan="2">Seleccione los permisos</th>
                    </tr>

                    @foreach ($permissions_array as $section)
                        <tr>
                            <td>{{ $section['description'] }}</td>
                            <td>
                                @foreach ($section['permissions'] as $key => $item)
                                    <label class="font-weight-normal"><input type="checkbox" value="{{ $key }}"
                                            wire:model='role_permissions'> {{ $item }}</label><br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                </table>

                <button type="submit" style="position: fixed; bottom: 20px; right: 30px;"
                    class="btn btn-primary float-right font-weight-bold">
                    <i class="fas fa-save"></i> GUARDAR</button>
            </div>
        </div>
    </form>
</div>
