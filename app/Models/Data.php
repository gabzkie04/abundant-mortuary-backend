<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'data';

    protected $fillable = [
        "planholder_id",
        "total_contract_price",
        "installment_due",
        "effective_date",
        "mode_of_premium",
        "terms",
        "insurable",
        "no_insurable",
    ];
}
