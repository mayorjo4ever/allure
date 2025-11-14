<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingCategory extends Model
{
    use HasFactory; protected $table = 'billing_categories';
    
    public function types() {
        return $this->hasMany('App\Models\BillType','categ_id'); 
    }


 /**
    public static function name($id){
        $name = BillingCategory::where('id',$id)->get()->first()->toArray();
        return $name['name'];
    }
     * **
     */
}
