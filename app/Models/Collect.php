<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    use HasFactory;

    protected $table = 'collect';

    protected $fillable = [
        "collector_id",
        "planholder_id",
        "amount",
        "or_number",
        "date_collect",
        "number_of_months_collected"
    ];
}
