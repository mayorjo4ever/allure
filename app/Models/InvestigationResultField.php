<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigationResultField extends Model
{
    use HasFactory;
    protected $fillable = ['template_id', 'name', 'type', 'label', 'options'];

    protected $casts = [
        'options' => 'array', // automatically decode JSON
    ];
     
    public function template()
    {
        return $this->belongsTo(InvestigationTemplate::class, 'template_id');
    }
}
