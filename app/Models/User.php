<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class User extends Model
{
    use HasFactory;

    public static function getAccountInfo($token) {
        $response = Http::post('https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . env('API_KEY'), [
            "idToken" => $token
        ]);
        $response->throw();
        return $response->json()['users'][0];
    }

    public static function getUIdByToken($token) {
        return User::getAccountInfo($token)['localId'];
    }

    public static function getUserByToken($token) {
        $uid = User::getUIdByToken($token);
        $user = DB::table('users')->where('uid', $uid)->first();
        if ($user) return $user;
        else {
            $user = new User();
            $user->uid = $uid;
            $user->save();
            return $user;
        }
    }

    public function lyrics() {
        return $this->hasMany(Lyric::class);
    }
}
