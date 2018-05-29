<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodTime extends Model
{
    protected $guarded = [];

    public function getId(){
        return $this->id;
    }

    public function getRoom(){
        return $this->belongsTo('App\Room','room_id','id');
    }
}
