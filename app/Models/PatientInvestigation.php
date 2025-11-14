<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInvestigation extends Model
{
    use HasFactory;
    protected $fillable = 
            [ 'patient_id', 'appointment_id', 'doctor_id', 
                'investigation_template_id','status','price'
                ]; 
    
    public function patient() {
       return $this->belongsTo(User::class,'patient_id');
    }
    
    public function appointment() {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }
    
    public function template() {
        return $this->belongsTo(InvestigationTemplate::class,'investigation_template_id');
    }
    
    public function results(){
       return $this->hasMany(InvestigationResult::class, 'investigation_id');
    }
    
    public function resultFiles(){
       return $this->hasMany(InvestigationResultFile::class, 'investigation_result_id');
    }
    
    
}
