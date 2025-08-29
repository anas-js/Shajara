<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Support\Facades\Auth;

class Viewer extends Model
{
    use HasFactory, HasUuids;

    protected $connection = "mysql";

    protected $fillable = [
        "user_id",
    ];


    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    public function isSee(User $profile)
    {
        return $this->views()->where('show_user_id', $profile->id)->exists();
    }

    public function isClick(Links $link)
    {
        return $this->clicks()->where('click_link_id', $link->id)->exists();
    }

    public function view(User $profile)
    {
        $profile->regInfo()->increment('page_views');

        $this->views()->create([
            "show_user_id" => $profile->id
        ]);
    }

    public function copyViewFromViewer(Viewer $profile_viewer)
    {

        $userViews = $this->views()->pluck('show_user_id');
        $userClicks = $this->clicks()->pluck('click_link_id');

        if ($profile_viewer->user) {
            $viewsNotInUser = $profile_viewer->views()->whereNotIn('show_user_id', $userViews)->get();

            $this->views()->createMany(
                $viewsNotInUser->map(function ($v) {
                    return $v->only('created_at', 'updated_at', 'show_user_id');
                })->toArray()
            );

            $clicksNotInUser = $profile_viewer->clicks()->whereNotIn('click_link_id', $userClicks)->get();
            $this->clicks()->createMany(
                $clicksNotInUser->map(function ($v) {
                    return $v->only('created_at', 'updated_at', 'click_link_id');
                })->toArray()
            );

        } else {
            $profile_viewer->views()->whereNotIn('show_user_id', $userViews)->update(['viewer_id' => $this->id]);
            $profile_viewer->clicks()->whereNotIn('click_link_id', $userClicks)->update(['viewer_id' => $this->id]);

            $profile_viewer->clicks()->delete();
            $profile_viewer->views()->delete();
            $profile_viewer->delete();
        }
    }
}
