<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecimenResultTemplate extends Model
{
    use HasFactory;
    protected $fillable =[
        'bill_type_id'
    ];
}
