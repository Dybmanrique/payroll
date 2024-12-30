<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FormCreate extends Component
{
    public $name;
    public $permissions_array;

    public $role_permissions = [];
    public $ids_permissions_selected = [];

    public function mount()
    {
        $this->permissions_array = config('permissions_array');
    }

    public function save()
    {
        foreach ($this->role_permissions as $value) {
            try {
                array_push($this->ids_permissions_selected, Permission::where('name', $value)->first()->id);
            } catch (\Exception $th) {
                $this->dispatch('message', code: '500', content: 'Algo salió mal');
            }
        }

        $role = Role::create([
            'name' => $this->name
        ]);

        $role->permissions()->sync($this->ids_permissions_selected);
        $this->reset('name', 'ids_permissions_selected', 'role_permissions');
        $this->dispatch('message', code: '200', content: 'Se ha creado el rol');
    }

    public function render()
    {
        return view('livewire.roles.form-create');
    }
}
