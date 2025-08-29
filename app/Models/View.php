<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        "show_user_id",
        'updated_at',
        'created_at'
    ];


    public function viewer() : BelongsTo {
        return $this->belongsTo(Viewer::class);
    }


}
