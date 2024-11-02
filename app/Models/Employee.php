<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
            'dni', 
            'birthdate', 
            'airhsp_code',
            'name',
            'last_name',
            'second_last_name',
            'remuneration',
            'start_validity',
            'end_validity',
            'bank_account',
            'date_entry',
            'working_hours',
            'essalud',
            'cuarta',
            'ruc',
            'gender',
            'group_id',
            'job_position_id',
            'level_id',
            'budgetary_objective_id',
            'pension_system',
            'afp_id',
            'afp_code',
            'afp_fing',
    ];

    protected $casts = [
        'essalud' => 'boolean',
        'cuarta' => 'boolean',
    ];

    public function afp(){
        return $this->belongsTo(Afp::class);
    }

    public function job_position(){
        return $this->belongsTo(JobPosition::class);
    }

    public function payrolls(){
        return $this->belongsToMany(Payroll::class);
    }
}
