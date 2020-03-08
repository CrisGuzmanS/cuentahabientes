<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'phone'];

    public function accounts(){
        return $this->belongsToMany('App\Account');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
