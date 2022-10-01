<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokenpassword extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'token'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
