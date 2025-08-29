<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registered extends Model
{
    use HasFactory;
    protected $table = 'registered';
    protected $connection = "mysql";


    protected $casts = [
        'isBlocked' => 'boolean'
    ];
}
