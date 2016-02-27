<?php namespace DashboardersHeaven\Services\Titles;

use DashboardersHeaven\Clip;
use DashboardersHeaven\Gamer;
use DashboardersHeaven\Screenshot;
use Illuminate\Database\Eloquent\Model;

class TitleService
{
    public function generate(Gamer $gamer, Model $media)
    {
        $mediaType = last(explode('\\', get_class($media)));

        if (!method_exists($this, "generate{$mediaType}Title")) {
            return '';
        }

        return $this->{"generate{$mediaType}Title"}($gamer, $media);
    }

    /**
     * Generate a title for a clip.
     *
     * @param \DashboardersHeaven\Gamer $gamer
     * @param \DashboardersHeaven\Clip  $clip
     *
     * @return string
     */
    private function generateClipTitle(Gamer $gamer, Clip $clip)
    {
        $game = (!is_null($clip->game)) ? $clip->game->title : $clip->game_title;

        $title = trim("{$gamer->gamertag} playing $game");

        if (!empty($clip->name)) {
            $title .= " ({$clip->name})";
        }

        return trim($title);
    }

    /**
     * Generate a title for a screenshot.
     *
     * @param \DashboardersHeaven\Gamer      $gamer
     * @param \DashboardersHeaven\Screenshot $screenshot
     *
     * @return string
     */
    private function generateScreenshotTitle(Gamer $gamer, Screenshot $screenshot)
    {
        $game = (!is_null($screenshot->game)) ? $screenshot->game->title : null;

        if (!empty($game)) {
            return trim("{$gamer->gamertag} playing $game");
        }

        return "{$gamer->gamertag}s screenshot";
    }
}
