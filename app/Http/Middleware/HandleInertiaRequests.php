<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if ($user) {
            $user->image_src = is_null($user->image_src) ?  env('JUZR_URL') . '/images/user.png' : env('JUZR_URL') . "/images/user/{$user->image_src}";
        }

        // $user->merge($user->regInfo()->get()->only('isBlocked'));

        // array_merge(,$user->regInfo()->pluck('links_clicks')->toArray())
        // dd($user->toArray());
        return array_merge(parent::share($request), [
            'auth.user' => fn() => is_null($user)
            ? null
            : array_merge($user->only('description', 'image_src', 'name', 'username'), $user->isRegistered() ? $user->regInfo()->select('isBlocked')->first()->toArray() : [])
            // ? $request->user()->only('id', 'name', 'email')
            // : null,
        ]);
    }
}
