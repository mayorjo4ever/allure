<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSpecimenResult extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id'];
    
     public function template() {
        return $this->belongsTo('App\Models\SpecimenResultTemplate','template_id');
    }    
   
}
