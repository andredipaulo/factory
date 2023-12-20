<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "loan_id",
        "amount",
        "payment_date",
        "amount_fees",
        "amount_paid",
    ];

    public function loan():BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'id');
    }
}
