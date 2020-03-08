<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['account_number', 'balance'];

    public function customers(){
        return $this->belongsToMany('App\Customer');
    }

}
