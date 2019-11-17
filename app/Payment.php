<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'old_balance', 'new_amount',
    ];

    public function client(){
        return $this->belongsTo('App\Client', 'client_id', 'id');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    // Set Status Model of Payment /////////// START ///////////
    const STATUS_COMPLETED    = 4;
    const STATUS_WAITING    = 1;
    const STATUS_PROCESSING  = 2;
    const STATUS_REJECTED = 3;
    const STATUS_PAY  = 0;
    public static function listStatus()
    {

        return [
            self::STATUS_COMPLETED    => 'COMPLETED',
            self::STATUS_WAITING    => 'WAITING FOR APPROVE',
            self::STATUS_PROCESSING => 'PROCESSING',
            self::STATUS_REJECTED  => 'REJECTED',
            self::STATUS_PAY  => 'WAITING FOR PAYMENT'
        ];
    }
    public function statusLabel()
    {
        $list = self::listStatus();

        // little validation here just in case someone mess things
        // up and there's a ghost status saved in DB
        return isset($list[$this->status])
            ? $list[$this->status]
            : $this->status;
    }

    // Set Status Model of Payment ////////// END /////////
}
