<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTicket extends Model
{
    use HasFactory; 
    protected $fillable = ['created_by','create_mode']; 

    public function user(){
        return $this->hasOne('App\Models\User','id','customer_id'); 
    }       
    
    public function specimen() {
         return $this->hasMany('App\Models\CustomerSpecimen','ticket_id'); 
    }
    
    public function results() {
         return $this->hasMany('App\Models\CustomerSpecimenResult','ticket_id'); 
    }
    
    public function payment() {
         return $this->hasMany('App\Models\PaymentLog','ticket_id');
    }
    
}
