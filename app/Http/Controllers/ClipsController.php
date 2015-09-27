<?php namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Clip;
use DashboardersHeaven\Gamer;
use Illuminate\Http\Request;

class ClipsController extends Controller
{
    public function clips(Request $request, $gamertag)
    {
        /**
         * @var Gamer $gamer
         */
        $gamer = Gamer::whereGamertag($gamertag)->first();
        $clips = Clip::with('game')->whereHas('gamer', function ($query) use ($gamer) {
            $query->where('xuid', '=', $gamer->xuid);
        })->orderBy('created_at', 'desc')->paginate(16);
        if (!$gamer) {
            app()->abort(404); //TODO: Probably make this better, maybe?
        }

        return view('pages.clips', ['gamer' => $gamer, 'clips' => $clips]);
    }

    public function clip($gamertag, $clipId)
    {
        $gamer = Gamer::whereGamertag($gamertag)->first();
        $clip  = Clip::with('game')->whereClipId($clipId)->first();

        return view('pages.clip', ['clip' => $clip, 'gamer' => $gamer]);
    }
}
