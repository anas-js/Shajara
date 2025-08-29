<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserController\RemoveAccountReq;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function registration(Request $request) {
        $user = $request->user();

        $user->viewer()->create();
        $user->regInfo()->create();

        return ['msg'=> 'User Registered Successfully'];
    }
    public function getLinks() {

    }
    public function removeAccount(RemoveAccountReq $request) {
        $key = $request->key;
        $user = User::find($request->user);
        if (!$user || !$user->checkHookKey($key)) {
            throw new HttpResponseException(response()->json(['message' => 'Unauthorized Access'], 401));
        }

        $user->links()->delete();
        $user->viewer()->delete();
        $user->regInfo()->delete();

        return ["done" => 'ok'];
    }
}
