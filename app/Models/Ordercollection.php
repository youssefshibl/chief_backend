<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordercollection extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $attributes = [];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }
    public function orders(){
        return $this->belongsToMany('App\Models\Order');
    }
}
