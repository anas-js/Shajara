<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hook extends Model
{
    protected $connection = "juzr_db";
    use HasFactory;
}
