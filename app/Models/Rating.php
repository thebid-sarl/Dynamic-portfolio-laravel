<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_ip', 'rating'];

    // Définir si l'IP a déjà noté
    public static function userHasRated($ip)
    {
        return Rating::where('user_ip', $ip)->exists();
    }
}
