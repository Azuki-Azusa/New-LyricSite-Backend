<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Lyric;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class FavoriteController extends Controller
{
    public function getMyFavorite(Request $request) {
        try {
            return $this->successfulRes(Lyric::getFavoriteByToken($request->token));
        }
        catch (Throwable $e) {
            return $this->throwException($e);
        }
    }

    public function isFavorite(Request $request, $token, $lyric_id) {
        return $this->successfulRes(Favorite::where([
            ['user_id', User::getUserByToken($token)->id],
            ['lyric_id', $lyric_id]
        ])->exists());
    }

    public function switchFavorite(Request $request) {
        $user_id =User::getUserByToken($request->token)->id;
        $favorite = Favorite::where([
            ['user_id', $user_id],
            ['lyric_id', $request->lyric_id]
        ])->first();
        if ($favorite) {
            $favorite->delete();
            return $this->successfulRes(false);
        }
        else {
            $favorite = new Favorite();
            $favorite->user_id = $user_id;
            $favorite->lyric_id = $request->lyric_id;
            $favorite->save();
            return $this->successfulRes(true);
        }
    }
}
