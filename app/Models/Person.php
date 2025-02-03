<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table = 'Person'; 

    protected $fillable = [
        'firstname', 'lastname', 'birthday', 'email', 'phone',
        'degree', 'country', 'city', 'header_image', 'domain', 'presentation'
    ];
}
