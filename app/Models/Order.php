<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'menu_id',
        'in_way',
        'finished',
        'canceled',
        'completed',
        'payment_method',
        'id',
        'work_mode',
        'number'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }
    public function collectionorders(){
        return $this->belongsToMany('App\Models\Order');
    }
}
