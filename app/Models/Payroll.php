<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'period',
        'processing_date',
        'payroll_type_id',
        'funding_resource_id',
    ];

    public function employees(){
        return $this->belongsToMany(Employee::class);
    }

    public function funding_resource(){
        return $this->belongsTo(FundingResource::class);
    }
}
