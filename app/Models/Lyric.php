<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;

    public static function getLyricsByToken($token) {
        $user = User::getUserByToken($token);
        return User::find($user->id)->lyrics;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}