<?php

return [
    // LAS FUENTES DE FINANCIAMIENTO YA NO SE CONSIDERAN PORQUE EXISTE TABLA BD
    'TIPO_CONCEPTO' => [
        'BY_CODE' => [
            '01' => 'INGRESOS',
            '02' => 'DESCUENTOS',
            '03' => 'APORTACIONES',
        ],
        'BY_NAME' => [
            'INGRESOS' => '01',
            'DESCUENTOS' => '02',
            'APORTACIONES' => '03',
        ],
    ],
    'CONCEPTOS' => [
        'BY_CODE' => [
            '0077' => 'HONORARIOS',
            '0001' => 'ONP',
            '0002' => 'AFP AP OBLIG',
            '0004' => 'AFP SEGURO',
            '0005' => 'AFP COM VAR',
            '0007' => 'CUARTA CATEGORÍA',
            '0009' => 'FALTAS Y TARDANZAS',
            '0008' => 'DESCUENTO JUDICIAL',
            '0007' => 'ESSALUD',
        ],
        'BY_NAME' => [
            'HONORARIOS' => '0077',
            'ONP' => '0001',
            'AFP AP OBLIG' => '0002',
            'AFP SEGURO' => '0004',
            'AFP COM VAR' => '0005',
            'CUARTA CATEGORÍA' => '0007',
            'FALTAS Y TARDANZAS' => '0009',
            'DESCUENTO JUDICIAL' => '0008',
            'ESSALUD' => '0007',
        ]
    ],
    'CODIGOS_TIPO_PLANILLA' => [
        'BY_CODE' => [
            '01' => 'ACTIVO',
            '02' => 'PENSIONISTA',
            '08' => 'RECONOCIMIENTOS ESTATALES',
            '04' => 'BENEFICIARIOS JUDICIALES Y TUTORES',
            '06' => 'PAGO ÚNICO',
            '07' => 'PROVISIONAL',
        ],
        'BY_NAME' => [
            'ACTIVO' => '01',
            'PENSIONISTA' => '02',
            'RECONOCIMIENTOS ESTATALES' => '08',
            'BENEFICIARIOS JUDICIALES Y TUTORES' => '04',
            'PAGO ÚNICO' => '06',
            'PROVISIONAL' => '07',
        ]
    ],
    'CODIGOS_CLASE_PLANILLA' => [
        'BY_CODE' => [
            '01' => 'HABERES',
            '03' => 'CAS',
            '04' => 'CONTRATOS FAG-PAG',
            '06' => 'MODALIDADES FORMATIVAS Y OTROS DE SIMILAR NATURALEZA',
            '16' => 'OCASIONALES',
            '20' => 'OCASIONALES CTS',
        ],
        'BY_NAME' => [
            'HABERES'  => '01',
            'CAS'  => '03',
            'CONTRATOS FAG-PAG'  => '04',
            'MODALIDADES FORMATIVAS Y OTROS DE SIMILAR NATURALEZA'  => '06',
            'OCASIONALES'  => '16',
            'OCASIONALES CTS'  => '20',
        ]
    ],
    'CODIGOS_TIPO_REGISTRO' => [
        'BY_CODE' => [
            '0' => 'PALMAS MAGISTERIALES',
            '1' => 'ACTIVOS',
            '4' => 'CAS',
            '9' => 'PROMOTORAS',
        ],
        'BY_NAME' => [
            'PALMAS MAGISTERIALES' => '0',
            'ACTIVOS' => '1',
            'CAS' => '4',
            'PROMOTORAS' => '9',
        ]
    ]
];
