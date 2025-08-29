<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkController\CreateReq;
use App\Http\Requests\LinkController\EditReq;
use App\Http\Requests\test;
use App\Models\Links;
use App\Models\Viewer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LinkController extends Controller
{
    public function create(CreateReq $request)
    {
        $user = $request->user();
        // dd($user->links->count());
        if (($user->links->count() + 1) > $user->limits('links_limit')) {
            throw ValidationException::withMessages([
                "url" => "تم تعدي حد الروابط {$user->limits('links_limit')} روابط"
            ]);
            // return abort(400,);
        }

        // if() {

        // }
        // for($i=0;$i<100;$i++){

        // }
        $user->links()->create($request->only(['url', 'icon', 'bg_color', 'color', 'status']));

        return redirect('/dashboard/links');
    }

    public function edit(EditReq $request, $id)
    {

        $user = $request->user();
        $link = $user->links()->find($id);
        if ($link) {
            $link->update($request->only(['url', 'icon', 'bg_color', 'color', 'status']));
            return redirect('/dashboard/links');
        }

        return abort(404);
    }
    public function remove(Request $request, $id)
    {

        $user = $request->user();
        $link = $user->links()->find($id);
        if ($link) {
            $link->delete();
            return ['msg' => 'done'];
        }

        return abort(404);
    }
    public function click(Request $request, $id)
    {
        $link = Links::find($id);

        if (!$link) {
            return abort(404);
        }


        $viewer = null;

        if ($request->cookie('viewer')) {
            $viewer = Viewer::find($request->cookie('viewer'));
        }

        if ($viewer && !$viewer->isClick($link)) {
            $link->increment('clicks');
            $link->user->regInfo()->increment('links_clicks');
            $viewer->clicks()->create([
                'click_link_id' => $id
            ]);
        }

        return ['msg'=>'done'];
    }
    // public function getLinkPaginate(Request $request) {

    //     $user = $request->user();

    //     $request->validate([
    //         'per' => ['required','int','in:10,20,30']
    //     ]);

    //     $per = $request->per;
    //     return $user->links()->simplePaginate($per);

    // }
}
