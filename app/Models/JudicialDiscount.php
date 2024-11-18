<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudicialDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'account',
        'dni',
        'is_deleted',
        'discount_type',
        'employee_id',
    ];

    public function payments(){
        return $this->belongsToMany(Payment::class);
    }
}
