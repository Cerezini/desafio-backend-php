<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;
    
    protected $dates = [
        'transaction_date'
    ];
}
