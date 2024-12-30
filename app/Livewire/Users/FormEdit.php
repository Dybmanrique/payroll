<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class FormEdit extends Component
{
    public $user;

    
    public $roles;

    public $user_roles = [];

    //ATRIBUTOS EMPLEADO PUBLICO
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        // $this->roles = Role::all();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        // foreach ($this->user->roles as $role) {
        //     array_push($this->user_roles, $role->id);
        // }
    }

    public function save()
    {
        $this->validate([
            
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|unique:users,email,' . $this->user->id,
        ]);

        $hasPassword = ($this->password !== "" && $this->password !== null);

        if ($hasPassword) {
            $this->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        try {
            $this->user->update([
                "name" => $this->name,
                "email" => $this->email,
            ]);

            if($hasPassword){
                $this->user->update([
                    "password" => Hash::make($this->password),
                ]);
            }

            // $this->user->roles()->sync($this->user_roles);
            $this->reset(['password','password_confirmation']);
            $this->dispatch('message', code: '200', content: 'Se ha editado el usuario');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo editar el usuario, quizá ya está registrado');
        }
    }

    public function render()
    {
        return view('livewire.users.form-edit');
    }
}
