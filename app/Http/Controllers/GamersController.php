<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Http\Requests;

class GamersController extends Controller
{
    /**
     * Display a listing of the gamers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gamers = Gamer::with('games')->orderBy('gamertag')->get();

        return view('pages.gamers.index', compact('gamers'));
    }

    /**
     * Display the gamers profile.
     *
     * @param string $gamertag
     *
     * @return \Illuminate\Http\Response
     */
    public function show($gamertag)
    {
        $gamer = Gamer::with(['games'])->whereGamertag($gamertag)->first();

        return view('pages.gamers.profile', compact('gamer'));
    }
}
