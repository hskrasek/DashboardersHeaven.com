<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Http\Requests;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class GamersController extends Controller
{
    /**
     * Display a listing of the gamers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gamers = Gamer::select('id', 'xuid', 'gamertag', 'display_pic')->orderBy('gamertag')->get();
        $counts = collect([
            'clips'       => collect(DB::table('clips')->whereIn('xuid', $gamers->pluck('xuid'))
                                       ->select(DB::raw('xuid, COUNT(id) AS count'))
                                       ->groupBy('xuid')
                                       ->get())->keyBy('xuid'),
            'screenshots' => collect(DB::table('screenshots')->whereIn('gamer_id', $gamers->pluck('id'))
                                       ->groupBy('gamer_id')
                                       ->select(DB::raw('gamer_id, COUNT(id) AS count'))->get())->keyBy('gamer_id'),
        ])->toArray();

        if (!$gamers) {
            app()->abort(404);
        }

        return view('pages.gamers.index', compact('gamers', 'counts'));
    }

    /**
     * Display the gamers profile.
     *
     * @param string $gamertag
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, $gamertag)
    {
        $gamer = Gamer::with([
            'games' => function ($query) {
                $query->where('is_app', '=', 0)
                      ->orderBy('last_unlock', 'DESC');
            }
        ])->whereGamertag($gamertag)->first();

        $online = false;

        try {
            $request = new Request('GET', $client->getConfig('base_uri') . "/{$gamer->xuid}/presence");
            $response = $client->send($request);
            $response = json_decode((string) $response->getBody());
            $online   = data_get($response, 'state') === 'Online' ? true : false;
        } catch (RequestException $e) {
        }

        if (empty($gamer)) {
            app()->abort(404);
        }

        return view('pages.gamers.profile', compact('gamer', 'online'));
    }
}
