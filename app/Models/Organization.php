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
}
