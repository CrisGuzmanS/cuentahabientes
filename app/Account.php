<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['customer_id', 'account_number', 'balance'];

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

}
