<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_method',
        'cc_number',
        'cc_expiry',
        'cc_cvv',
        'cc_customer_name',
    ];
}
