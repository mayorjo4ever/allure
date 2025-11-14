<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigationTemplate extends Model
{
    use HasFactory;
     protected $fillable = ['name', 'price'];
       
    public function fields()
    {
        return $this->hasMany(InvestigationResultField::class, 'template_id');
    }
    
    public static function bill_name($id){
        $temp = InvestigationTemplate::find($id);
        return $temp->name; 
    }
}
