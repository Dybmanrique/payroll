<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class FormEdit extends Component
{
    public $role;
    public $name;
    public $permissions_array;

    public $role_permissions = [];
    public $ids_permissions_selected = [];

    public function mount()
    {
        $this->permissions_array = config('permissions_array');
        $this->name = $this->role->name;
        foreach($this->role->permissions as $permission){
            array_push($this->role_permissions, $permission->name);
        }
    }

    public function save()
    {
        foreach ($this->role_permissions as $value) {
            array_push($this->ids_permissions_selected, Permission::where('name', $value)->first()->id);
        }

        $this->role->update([
            'name' => $this->name
        ]);

        $this->role->permissions()->sync($this->ids_permissions_selected);
        $this->reset('ids_permissions_selected');
        $this->dispatch('message', code: '200', content: 'Se ha editado el rol');
    }

    public function render()
    {
        return view('livewire.roles.form-edit');
    }
}
