<?php namespace DashboardersHeaven\Events;

use DashboardersHeaven\Game;
use Illuminate\Queue\SerializesModels;

class GameCreated extends Event
{
    use SerializesModels;

    /**
     * @var \DashboardersHeaven\Game
     */
    public $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
