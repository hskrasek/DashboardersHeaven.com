<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Game;
use DashboardersHeaven\Http\Requests;

class GamesController extends Controller
{
    public function listGames()
    {
        $games = Game::whereIsApp(false)->orderBy('title', 'ASC')->paginate(16);

        if (!$games) {
            app()->abort(404);
        }

        return view('pages.games.index', ['games' => $games]);
    }

    public function gameInfo($title)
    {
        $game = Game::with(['gamers'])->whereTitle($title)->first();

        if (!$game) {
            app()->abort(404);
        }

        return view('pages.games.game', ['game' => $game, 'gamers' => $game->gamers]);
    }
}
