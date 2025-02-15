<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    protected $permissions = [
        'dashboard.index',
        //AFP
        'afps.index',
        'afps.create',
        'afps.edit',
        'afps.delete',
        //budgetary_objectives
        'budgetary_objectives.index',
        'budgetary_objectives.create',
        'budgetary_objectives.edit',
        'budgetary_objectives.delete',
        //groups
        'groups.index',
        'groups.create',
        'groups.edit',
        'groups.delete',
        //job_positions
        'job_positions.index',
        'job_positions.create',
        'job_positions.edit',
        'job_positions.delete',
        //levels
        'levels.index',
        'levels.create',
        'levels.edit',
        'levels.delete',
        //employees
        'employees.index',
        'employees.create',
        'employees.edit',
        'employees.delete',
        //payroll_types
        'payroll_types.index',
        'payroll_types.create',
        'payroll_types.edit',
        'payroll_types.delete',
        //funding_resources
        'funding_resources.index',
        'funding_resources.create',
        'funding_resources.edit',
        'funding_resources.delete',
        //payrolls
        'payrolls.index',
        'payrolls.create',
        'payrolls.edit',
        'payrolls.delete',
        //settings
        'settings.index',
        'settings.edit',
        //users
        'users.index',
        'users.create',
        'users.edit',
        'users.delete',
        //roles
        'roles.index',
        'roles.create',
        'roles.edit',
        'roles.delete',
        //identity_types
        'identity_types.index',
        'identity_types.create',
        'identity_types.edit',
        'identity_types.delete',
    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = Role::create(['name' => 'Administrador']);
        // Crear los permisos
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission])->assignRole($admin);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {        
        foreach ($this->permissions as $permission) {
            Permission::findByName($permission)->delete();
        }

        Role::findByName('Administrador')->delete();
    }
};
