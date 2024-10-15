<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetaryObjective extends Model
{
    use HasFactory;

    protected $fillable = [
        'pneumonic',
        'function',
        'program',
        'subprogram',
        'program_p',
        'act_proy',
        'component',
        'cas_classifier',
        'essalud_classifier',
        'name',
    ];
}
