<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBill extends Model
{
    use HasFactory;
    protected $fillable = ['ticketno','appointment_id','patient_id','bill_type_ids','total_cost',
         'amount_paid','discount', 'refund', 'payment_completed'];
     
     public function payment() {
         return $this->hasMany('App\Models\PaymentLog','customer_bill_id');
    }
    
     public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function investigations()
    {
        return $this->hasMany(PatientInvestigation::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'patient_id');
    }
    
    public function invoice() {
        return $this->hasOne(PaymentInvoice::class);
    }
}
