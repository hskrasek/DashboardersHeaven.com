<?php namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Clip;
use DashboardersHeaven\Gamer;
use Illuminate\Http\Request;

class ClipsController extends Controller
{
    public function index()
    {
        $clips = Clip::with(['game', 'gamer'])->orderBy('recorded_at', 'desc')->paginate(16);

        if (!$clips) {
            app()->abort(404);
        }

        return view('pages.clips.index', ['clips' => $clips]);
    }

    public function clip($clipId)
    {
        $clip = Clip::with(['game', 'gamer'])->whereClipId($clipId)->first();

        if (!$clip) {
            app()->abort(404);
        }

        return view('pages.clips.clip', ['clip' => $clip, 'gamer' => $clip->gamer]);
    }

    public function clipsForGamertag(Request $request, $gamertag)
    {
        $gamer = Gamer::whereGamertag($gamertag)->first();

        if (!$gamer) {
            app()->abort(404); //TODO: Probably make this better, maybe?
        }

        $clips = Clip::with('game')->whereHas('gamer', function ($query) use ($gamer) {
            $query->where('xuid', '=', $gamer->xuid);
        })->orderBy('recorded_at', 'desc')->paginate(16);

        return view('pages.gamers.clips', ['gamer' => $gamer, 'clips' => $clips]);
    }

    public function clipForGamertag(Request $request, $gamertag, $clipId)
    {
        $gamer = Gamer::whereGamertag($gamertag)->first();

        if (!$gamer) {
            app()->abort(404);
        }

        $clip = Clip::with('game')->whereClipId($clipId)->first();

        if (!$clip) {
            app()->abort(404);
        }

        return view('pages.clips.clip', ['clip' => $clip, 'gamer' => $gamer]);
    }
}
