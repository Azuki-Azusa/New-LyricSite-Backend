<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;

    public static function getUploadByToken($token) {
        $user = User::getUserByToken($token);
        return User::find($user->id)->lyrics()->select('id', 'title', 'creater', 'has_furigana', 'video_id')->get();
    }

    public static function getFavoriteByToken($token) {
        $user = User::getUserByToken($token);
        $favorites = User::find($user->id)->favorites;
        $result = [];
        foreach($favorites as $favorite) {
            array_push($result, $favorite->lyric);
        }
        return $result;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }
}