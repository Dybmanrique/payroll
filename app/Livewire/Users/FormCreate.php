<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class FormCreate extends Component
{
    public $roles;

    public $user_roles = [];

    //ATRIBUTOS EMPLEADO PUBLICO
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            User::create([
                "name" => $this->name,
                "email" => $this->email,
                "password" => Hash::make($this->password),
            ]);
    
            $this->reset('email', 'password', 'password_confirmation', 'name');
            $this->dispatch('message', code: '200', content: 'Se ha creado el usuario');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear el usuario, quizá ya está registrado');
        }
    }
    
    public function render()
    {
        return view('livewire.users.form-create');
    }
}
