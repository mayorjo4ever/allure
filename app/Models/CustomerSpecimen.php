<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSpecimen extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id'];

    public function bill() {
         return $this->belongsTo('App\Models\BillType','bill_type_id');
    }
    


}
