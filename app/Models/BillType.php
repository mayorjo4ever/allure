<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillType extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo('App\Models\BillingCategory','categ_id');
    }

    public function template() {
        return $this->hasMany('App\Models\SpecimenResultTemplate','bill_type_id')->where('status', 1);
    }

    public static function bill_name($id){
        $name = BillType::where('id',$id)->first();
        return  $name['name'] ?? "unknown";
    }
    public static function bill_info($id){
        $info = BillType::where('id',$id)->first()->toArray();
        return $info;
    }

}
