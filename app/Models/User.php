<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = "juzr_db";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        "description",
        'email',
        "username",
        'password',
        "timezone",
        'notifs_apps',
        'notifs_ads',
        'notifs_important',
        'email_verified_at',
        'image_src',
        'private'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'timezone',
        'updated_at',
        'id',
        'created_at',
        'email',
        'notifs_apps',
        'notifs_ads',
        'notifs_important',
        // 'image_src',
        'private'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notifs_apps' => 'boolean',
        'notifs_ads' => 'boolean',
        'notifs_important' => 'boolean',
        'private' => 'boolean'
    ];

    // RELISHONS
    public function regInfo(): HasOne
    {
        return $this->hasOne(Registered::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Links::class);
    }

    // FUNCTION
    public function isRegistered()
    {
        return $this->regInfo()->exists();
    }

    public function limits($limit_key = null, $select = null)
    {
        $limits = $this->regInfo()->first()->only('links_limit');
        if (!isset($limit_key)) {
            return collect($limits)->only($select);
        }

        return $limits[$limit_key];
    }


    public function getUserURLImage(): ?string
    {
        return env('JUZR_URL') . "/images/user/{$this->image_src}";
    }

    public function viewer(): HasOne
    {
        return $this->hasOne(Viewer::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function session($id)
    {
        return $this->sessions()->where('id', $id)->first();
    }

    public function hook(): HasMany
    {
        return $this->hasMany(Hook::class);
    }


    public function checkHookKey($key)
    {
        $hook = $this->hook()->where('for', 'shajara')->first();
        if (!$hook) {
            return false;
        }
        if (Hash::check($key, $hook->key)) {
            $this->hook()->where('for', 'shajara')->delete();
            return true;
        }

        return false;
    }
}
