<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersHistory extends Model
{
    use HasFactory;
     protected $fillable = ['user_id','regno', 'history', 'drug_history', 'family_history'];
     
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
