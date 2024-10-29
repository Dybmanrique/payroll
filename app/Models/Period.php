<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'mounth',
        'payroll_id',
    ];

    public function employees(){
        return $this->belongsToMany(Employee::class, 'payments');
    }

    public function payroll(){
        return $this->belongsTo(Payroll::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
