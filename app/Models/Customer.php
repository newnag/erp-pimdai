<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_type',
        'customer_type',
        'credit_limit',
        'contact_id',
        'company_name',
        'tax_id',
        'com_branch',
        'phone',
        'email',
        'website',
        'address',
        'postal_code',
        'delivery_note',
        'contact_name',
        'contact_email',
        'contact_phone',
        'bank',
        'bank_name',
        'bank_acc_no',
        'bank_branch',
        'link_file',
        'note',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];
}
