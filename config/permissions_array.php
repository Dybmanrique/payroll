<?php

return [
    'dashboard' => [
        'description' => 'Panel de administración',
        'permissions'=> [
            'dashboard.index' => 'Ver el panel de administración',
        ],
    ],
    'afps' => [
        'description' => 'Afps',
        'permissions'=> [
            'afps.index' => 'Visualizar las afps',
            'afps.create' => 'Crear las afps',
            'afps.edit' => 'Editar las afps',
            'afps.delete' => 'Eliminar las afps',
        ],
    ],
    'identity_types' => [
        'description' => 'Tipos de identificación',
        'permissions'=> [
            'identity_types.index' => 'Visualizar los tipos de identificación',
            'identity_types.create' => 'Crear los tipos de identificación',
            'identity_types.edit' => 'Editar los tipos de identificación',
            'identity_types.delete' => 'Eliminar los tipos de identificación',
        ],
    ],
    'budgetary_objectives' => [
        'description' => 'Metas presupuestales',
        'permissions'=> [
            'budgetary_objectives.index' => 'Visualizar las metas presupuestales',
            'budgetary_objectives.create' => 'Crear las metas presupuestales',
            'budgetary_objectives.edit' => 'Editar las metas presupuestales',
            'budgetary_objectives.delete' => 'Eliminar las metas presupuestales',
        ],
    ],
    'groups' => [
        'description' => 'Grupos',
        'permissions'=> [
            'groups.index' => 'Visualizar los grupos',
            'groups.create' => 'Crear los grupos',
            'groups.edit' => 'Editar los grupos',
            'groups.delete' => 'Eliminar los grupos',
        ],
    ],
    'job_positions' => [
        'description' => 'Cargos laborales',
        'permissions'=> [
            'job_positions.index' => 'Visualizar los cargos laborales',
            'job_positions.create' => 'Crear los cargos laborales',
            'job_positions.edit' => 'Editar los cargos laborales',
            'job_positions.delete' => 'Eliminar los cargos laborales',
        ],
    ],
    'levels' => [
        'description' => 'Niveles',
        'permissions'=> [
            'levels.index' => 'Visualizar los niveles',
            'levels.create' => 'Crear los niveles',
            'levels.edit' => 'Editar los niveles',
            'levels.delete' => 'Eliminar los niveles',
        ],
    ],
    'employees' => [
        'description' => 'Empleados',
        'permissions'=> [
            'employees.index' => 'Visualizar los empleados',
            'employees.create' => 'Crear los empleados',
            'employees.edit' => 'Editar los empleados',
            'employees.delete' => 'Eliminar los empleados',
        ],
    ],
    'payroll_types' => [
        'description' => 'Tipos de planillas',
        'permissions'=> [
            'payroll_types.index' => 'Visualizar los tipos de planillas',
            'payroll_types.create' => 'Crear los tipos de planillas',
            'payroll_types.edit' => 'Editar los tipos de planillas',
            'payroll_types.delete' => 'Eliminar los tipos de planillas',
        ],
    ],
    'funding_resources' => [
        'description' => 'Fuentes de financiamiento',
        'permissions'=> [
            'funding_resources.index' => 'Visualizar las fuentes de financiamiento',
            'funding_resources.create' => 'Crear las fuentes de financiamiento',
            'funding_resources.edit' => 'Editar las fuentes de financiamiento',
            'funding_resources.delete' => 'Eliminar las fuentes de financiamiento',
        ],
    ],
    'payrolls' => [
        'description' => 'Planillas',
        'permissions'=> [
            'payrolls.index' => 'Visualizar las planillas',
            'payrolls.create' => 'Crear las planillas',
            'payrolls.edit' => 'Editar las planillas',
            'payrolls.delete' => 'Eliminar las planillas',
        ],
    ],
    'settings' => [
        'description' => 'Parámetros',
        'permissions'=> [
            'settings.index' => 'Visualizar los parámetros',
            'settings.edit' => 'Editar los parámetros',
        ],
    ],
    'users' => [
        'description' => 'Usuarios',
        'permissions'=> [
            'users.index' => 'Visualizar los usuarios',
            'users.create' => 'Visualizar los usuarios',
            'users.edit' => 'Visualizar los usuarios',
            'users.delete' => 'Visualizar los usuarios',
        ],
    ],
    'roles' => [
        'description' => 'Roles',
        'permissions'=> [
            'roles.index' => 'Visualizar los roles',
            'roles.create' => 'Visualizar los roles',
            'roles.edit' => 'Visualizar los roles',
            'roles.delete' => 'Visualizar los roles',
        ],
    ],
];

//MODO DE LLAMAR AL ARRAY -> $array = config('arrays.mi_array');