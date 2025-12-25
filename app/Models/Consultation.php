<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id','user_id','doctor_id','regno',
        'visit_date','complaint','diagnosis'
    ];


    public function appointment() {
         return $this->belongsTo(Appointment::class);
    }
    public function patient() {
         return $this->belongsTo(User::class,'user_id');
    }
    
    public function prescription() {
         return $this->hasMany(Prescription::class,'user_id');
    }
    
    public function medicalTests() {
         return $this->hasMany(MedicalTest::class,'user_id');
    }
    
}
