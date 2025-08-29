<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Viewer as ModelsViewer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class Viewer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profile = $this->getProfile($request->route('username'));
        if (!$profile) {
            return abort(404);
        }

        $request->merge(['profile' => $profile]);


        $user = Auth::user();
        $viewer = $this->getViewer($request->cookie('viewer'));



        if ($viewer) {
            if ($user && ($user->viewer->id != $viewer->id)) {
                $user->viewer->copyViewFromViewer($viewer);
                $viewer = $user->viewer;
            }
        } else {
            if ($user) {
                $viewer = $user->viewer;
            } else {
                $viewer = ModelsViewer::create();
            }

        }

        // watch
        if (!$viewer->isSee($profile)) {
            $viewer->view($profile);
        }

        Cookie::queue(Cookie::forever('viewer', $viewer->id,domain:env('APP_DOMAIN')));
        // dd($viewer->id);
        return $next($request);
    }

    public function getViewer($viewerID)
    {
        if ($viewerID) {
            return ModelsViewer::find($viewerID);
        }
        return null;
    }

    private function getProfile($username)
    {
        // $username = '@'.str_replace('-','_',$username);
        $profile = User::where("username", $username)->get()->first();


        if (!$profile || !$profile->isRegistered()) {
            return null;
        }

        if ($profile->private) {
            $profile->name = Str::padRight(mb_substr($profile->name, 0, 1), 9, "*");
            $profile->description = Str::padLeft("", 5, "*");
            $profile->makeHidden(['image_src']);
        }

        return $profile;
    }
}
