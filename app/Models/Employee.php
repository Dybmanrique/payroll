<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $table = 'employees';
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
        'password',
        'afp_code',
        'afp_fing',
        'afp_id',
        'afp_commission_type',
        'identity_type_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'cuarta' => 'boolean',
    ];

    public function getAuthIdentifierName()
    {
        return 'identity_number'; // Laravel autenticará usando el DNI
    }

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

    public function contracts(){
        return $this->hasMany(Contract::class);
    }
    public function current_contracts(){
        return $this->hasMany(Contract::class)->where(function ($query) {
            $query->where('end_validity', '>=', now()) // Contratos con fecha de finalización futura
                  ->orWhereNull('end_validity');       // Contratos sin fecha de finalización
        });;
    }
}
