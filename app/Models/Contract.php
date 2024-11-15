<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'remuneration',
        'start_validity',
        'end_validity',
        'working_hours',
        'employee_id',
        'job_position_id',
        'level_id',
        'budgetary_objective_id',
    ];

    protected $casts = [
        'start_validity' => 'date',
        'end_validity' => 'date',
    ];

    public function budgetary_objective(){
        return $this->belongsTo(BudgetaryObjective::class);
    }
    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function job_position(){
        return $this->belongsTo(JobPosition::class);
    }
}
