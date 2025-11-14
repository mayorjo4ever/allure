<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;
    
    protected $fillable = ['ticket_no','appointment_id'];   
    
    public function ticket() {
         return $this->belongsTo('App\Models\CustomerBill','appointment_id'); 
    }
}
