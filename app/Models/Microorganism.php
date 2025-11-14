<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Microorganism extends Model
{
    use HasFactory;
    
    public function treatment(){
          return $this->hasOne('App\Models\Treatment','microorganism_id'); 
    }
}
