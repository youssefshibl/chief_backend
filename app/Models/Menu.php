<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'restaurant_id',
    ];
    public function review()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function compoenents()
    {
        return $this->belongsToMany('App\Models\Component', 'menu_components', 'menu_id', 'component_id');
    }
    public function size()
    {
        return $this->belongsToMany('App\Models\Size', 'menu_size', 'menu_id', 'size_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
