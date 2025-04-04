<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'basic',
        'afp_discount',
        'onp_discount',
        'fines_discount',
        'total_remuneration',
        'total_discount',
        'total_contribution',
        'net_pay',
        'essalud',
        'obligatory_afp',
        'life_insurance_afp',
        'variable_afp',
        'days',
        'days_discount',
        'hours_discount',
        'minutes_discount',
        'refound',
        'aguinaldo',
        'contract_id',
        'period_id',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function afp()
    {
        return $this->belongsTo(Afp::class);
    }

    public function judicial_discounts() {
        return $this->belongsToMany(JudicialDiscount::class)->withPivot('amount');
    }
}
