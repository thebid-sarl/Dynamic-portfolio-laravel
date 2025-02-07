<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $fillable = ['ip_address', 'has_liked'];

    public static function getLikeCount()
{
    return self::where('has_liked', true)->count();
}
}
