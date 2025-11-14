<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['customer_bill_id',
        'doctor_id','user_id','appointment_date','status','ticket_no'
    ];
    
    protected $dates = ['appointment_date'];
    
    protected $casts = [
        'appointment_date' => 'datetime',
    ];
    
    public function doctor() {
        return $this->belongsTo(Admin::class,'doctor_id'); 
    }
    
    public function patient() {
        return $this->belongsTo(User::class,'user_id'); 
    }
    
    public function getHumanDateAttribute()
        {
            if ($this->appointment_date->isTomorrow()) {
                return 'Tomorrow';
            } elseif ($this->appointment_date->isYesterday()) {
                return 'Yesterday';
            }
            return $this->appointment_date->diffForHumans();
        }
        
        public function consultation() {
            return $this->hasOne(Consultation::class);
        }
       
        public function questions() {
            return $this->hasMany(QuestionnaireResponse::class);
        }
        public function vitals() {
             return $this->hasOne(Vital::class);
        }        
        
        public function investigations() {
            return $this->hasMany(PatientInvestigation::class);
        }
        
        public function prescriptions(){
            return $this->hasMany(Prescription::class, 'appointment_id');
        }
        
        public function bills() {
            return $this->hasOne(CustomerBill::class,'appointment_id');
        }
}
