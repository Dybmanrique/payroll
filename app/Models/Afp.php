<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afp extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'obligatory_contribution',
        'life_insurance',
        'variable_commission',
    ];
}
