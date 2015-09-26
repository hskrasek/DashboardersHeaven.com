<?php namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Clip;
use DashboardersHeaven\Gamer;
use Illuminate\Pagination\LengthAwarePaginator;

class ClipsController extends Controller
{
    public function clips($gamertag)
    {
        /**
         * @var Gamer $gamer
         */
        $gamer = Gamer::with([
            'clips' => function ($query) {
                $query->where('expired', '!=', true)
                      ->orderBy('created_at', 'desc');
            },
            'clips.game'
        ])->whereGamertag($gamertag)->first();
        $clips = new LengthAwarePaginator($gamer->clips, $gamer->clips->count(), 16);
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
