<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class profileController extends Controller
{
    public function view(Request $request,$username)
    {
        $profile = $request->profile;

        if($profile->regInfo->isBlocked) {
            return redirect('/');
        }
        $profile->links = $profile->links()->where('status',1)->get()->makeHidden(['status']);

        // dd($profile->image_src);

        if($profile->private) {
            $profile->makeVisible(['image_src']);
            $profile->image_src = env('JUZR_URL') . '/images/user.png';
        } else {
            $profile->image_src = is_null($profile->image_src) ?  env('JUZR_URL') . '/images/user.png' : env('JUZR_URL') . "/images/user/{$profile->image_src}";
        }

        return Inertia::render('profile',[
            'profile' => $profile
        ]);
    }


}
