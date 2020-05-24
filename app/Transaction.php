<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";
    protected $fillable = ["origin_account_id", "destination_account_id", "customer_id", "amount"];
}
