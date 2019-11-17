<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    public function payments(){
        return $this->hasMany('App\Payment', 'client_id', 'id');
    }

    public function balance()
    {
        return $this->belongsToMany('App\Payment')->withPivot('old_balance','new_amount');
    }

}
