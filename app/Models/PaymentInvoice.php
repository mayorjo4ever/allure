<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInvoice extends Model
{
    protected $fillable = [
        'organization_id','organization_id','customer_bill_id',
        'patient_id','account_id','amount','discount','created_by',
        'appointment_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class,'patient_id');
    }
    
    public function bill()
    {
        return $this->belongsTo(CustomerBill::class,'customer_bill_id');
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_id');
    }
}
