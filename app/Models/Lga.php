<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    use HasFactory;
    
     public static function name($id=null) {
        if($id==""): return "--:--"; endif;
        $result = Lga::where('id',$id)->first();
        return $result['name']; 
    }  
}
