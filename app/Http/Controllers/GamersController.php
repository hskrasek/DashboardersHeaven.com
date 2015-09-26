<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Http\Requests;

class GamersController extends Controller
{
    /**
     * Display a listing of the gamers.
     *
     * @return Response
     */
    public function index()
    {
        $gamers = Gamer::with('games')->get();

        return view('pages.gamers', compact('gamers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }
}
