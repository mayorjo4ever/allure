<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireResponse extends Model
{
    use HasFactory;
    protected $fillable = 
            [
                'questionnaire_id','patient_id','appointment_id',
                'regno','answer'
            ];
}
