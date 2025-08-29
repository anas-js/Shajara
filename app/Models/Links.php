<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Links extends Model
{
    use HasFactory;

    protected $table = 'links';
    protected $connection = "mysql";
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'icon',
        'color',
        'bg_color',
        'status'

    ];
    protected $hidden = [
        'updated_at',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
