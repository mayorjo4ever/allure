<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigationResult extends Model
{
    use HasFactory;
     protected $fillable = 
            [ 'investigation_id', 'field_id', 'value'              
                ]; 
     
  
    public function files()
    {
        return $this->hasMany(InvestigationResultFile::class);
    }

    public function field()
    {
        return $this->belongsTo(InvestigationResultField::Field::class, 'field_id');
    }

    public function investigation()
    {
        return $this->belongsTo(PatientInvestigation::class, 'investigation_id');
    }
}
