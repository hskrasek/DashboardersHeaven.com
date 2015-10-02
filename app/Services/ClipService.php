<?php namespace DashboardersHeaven\Services;

use DashboardersHeaven\Clip;
use DashboardersHeaven\Gamer;

class ClipService
{
    public function generateTitle(Clip $clip, Gamer $gamer)
    {
        $game = (!is_null($clip->game)) ? $clip->game->title : $clip->game_title;

        $clipTitle = trim("{$gamer->gamertag} playing $game");

        if (!empty($clip->name)) {
            $clipTitle .= " ({$clip->name})";
        }

        return trim($clipTitle);
    }
}
