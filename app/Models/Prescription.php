<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    
    protected $fillable = ['appointment_id',
        'patient_id', 'doctor_id', 'item_id', 'item_type','dosage',
        'type_id', 'type_name', 'quantity', 'unit_price', 'total_price'
    ];

    public function item()
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }
    
}
