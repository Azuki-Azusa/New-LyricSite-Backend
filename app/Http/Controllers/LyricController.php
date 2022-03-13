<?php

namespace App\Http\Controllers;

use App\Models\Lyric;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;

class LyricController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request) {
        try {
            $this->checkParaOfRequest($request, ['token', 'title', 'lyric', 'video_id', 'creater']);
            $user = User::getUserByToken($request->token);
            $lyric = new Lyric();
            $lyric->title = htmlspecialchars($request->title, ENT_NOQUOTES);
            $lyric->lyric = htmlspecialchars($request->lyric, ENT_NOQUOTES);
            $lyric->video_id = htmlspecialchars($request->video_id, ENT_NOQUOTES);
            $lyric->creater = htmlspecialchars($request->creater, ENT_NOQUOTES);
            $lyric->user_id = $user->id;
            $lyric->save();
            return response()->json([
                'state' => 1,
                'lyric_id' => $lyric->id,
            ]);
        }
        catch (Throwable $e) {
            return $this->throwException($e);
        }
    }

    public function read(Request $request, $id) {
        return $this->successfulRes(DB::table('lyrics')->find($id));
    }

    public function update(Request $request) {
        try {
            $this->checkParaOfRequest($request, ['token', 'title', 'lyric', 'video_id', 'creater']);
            $user = User::getUserByToken($request->token);
            $lyric = Lyric::find($request->lyric_id);
            if ($user->id == $lyric->user_id) {
                $lyric->title = htmlspecialchars($request->title, ENT_NOQUOTES);
                $lyric->lyric = htmlspecialchars($request->lyric, ENT_NOQUOTES);
                $lyric->video_id = htmlspecialchars($request->video_id, ENT_NOQUOTES);
                $lyric->creater = htmlspecialchars($request->creater, ENT_NOQUOTES);
                $lyric->save();
                return response()->json([
                    'state' => 1,
                    'lyric_id' => $lyric->id,
                ]);
            }
            else {
                throw new Exception('Not match.');
            }
        }
        catch (Throwable $e) {
            return $this->throwException($e);
        }
    }

    public function delete(Request $request, $token, $lyric_id) {
        try {
            $user = User::getUserByToken($token);
            $lyric = Lyric::find($lyric_id);
            if ($user->id == $lyric->user_id) {
                $lyric->delete();
                return $this->successfulRes(Lyric::getLyricsByToken($token));
            }
            else {
                throw new Exception('Not match.');
            }
        }
        catch (Throwable $e) {
            return $this->throwException($e);
        }
    }

    public function getAll() {
        return $this->successfulRes(DB::table('lyrics')->get());
    }

    public function getMyUpload(Request $request, $token) {
        try {
            return $this->successfulRes(Lyric::getLyricsByToken($token));
        }
        catch (Throwable $e) {
            return $this->throwException($e);
        }
    }
}