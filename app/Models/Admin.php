<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticable
{
    use HasFactory, HasRoles; 
    use Notifiable; 
    
    protected $guard = 'admin'; 
         
    public function routeNotificationForSms()
    {
        return $this->mobile; // or however your phone number is stored
    }
    
     protected $fillable = [
        'surname',
         'name',
        'firstname',
        'othername',
        'email',
        'mobile',
        'password',
        'status'
    ];
}
