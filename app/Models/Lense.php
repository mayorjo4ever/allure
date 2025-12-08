<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lense extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'categ_id', 'type_id', 'status',
        'purchase_price', 'sales_price', 'cum_qty', 'qty_rem', 'pix_name'
    ];

    protected $appends = ['type_name'];

    public function getTypeNameAttribute()
    {
        return match($this->type_id) {
            1 => 'White',
            2 => 'Photo ARC',
            3 => 'Blue Cut Photo',
            default => 'White',
        };
    }
}
