<?php

namespace App\Http\Controllers;

use App\Models\Lyric;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class LyricController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request) {
        try {
            $id = User::getLocalIdByToken($request->token);
            $lyric = new Lyric();
            $lyric->title = $request->title;
            $lyric->lyric = $request->lyric;
            $lyric->video_id = $request->video_id;
            $lyric->user_id = $id;
            $lyric->save();
            return response()->json([
                'state' => 1,
                'lyric_id' => $lyric->id,
            ]);
        }
        catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json([
                'state' => 0,
                'errMsg' => $e->getMessage(),
            ]);
        }
    }

    public function read(Request $request, $id) {
        return response()->json(DB::table('lyrics')->find($id));
    }

    public function update() {

    }

    public function delete() {

    }

    public function getAll() {
        return response()->json(DB::table('lyrics')->get());
    }
}
