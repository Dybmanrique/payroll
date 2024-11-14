<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetaryObjective extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'programa_pptal',
        'producto_proyecto',
        'activ_obra_accinv',
        'funcion',
        'division_fn',
        'grupo_fn',
        'sec_func',
        'cas_classifier',
        'essalud_classifier',
        'aguinaldo_classifier',
        'name',
    ];
}
