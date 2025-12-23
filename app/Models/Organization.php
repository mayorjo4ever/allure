<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function openedInvoices()
    {
        return $this->hasMany(PaymentInvoice::class, 'organization_id')
                    ->where('status', 'opened');
    }

    public function closedInvoices()
    {
        return $this->hasMany(PaymentInvoice::class, 'organization_id')
                    ->where('status', 'closed');
    }
    public static function name($id){
        $sql = Organization::findOrFail($id);
        return $sql->name;
    }
}
