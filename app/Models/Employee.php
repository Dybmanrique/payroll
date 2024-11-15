<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity_number',
        'birthdate',
        'airhsp_code',
        'name',
        'last_name',
        'second_last_name',
        'bank_account',
        'date_entry',
        'pension_system',
        'cuarta',
        'ruc',
        'gender',
        'afp_code',
        'afp_fing',
        'afp_id',
        'identity_type_id',
        'group_id',
    ];

    protected $casts = [
        'cuarta' => 'boolean',
    ];

    public function afp(){
        return $this->belongsTo(Afp::class);
    }

    public function identity_type(){
        return $this->belongsTo(IdentityType::class);
    }

    public function job_position(){
        return $this->belongsTo(JobPosition::class);
    }

    public function payrolls(){
        return $this->belongsToMany(Payroll::class);
    }

    public function judicial_discounts(){
        return $this->hasMany(JudicialDiscount::class);
    }
}
