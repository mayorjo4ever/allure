<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigationResultFile extends Model
{
    use HasFactory;
    
    protected $fillable = ['investigation_result_id', 'field_id', 'file_path'];

    public function result()
    {
        return $this->belongsTo(InvestigationResult::class, 'investigation_result_id');
    }
}
