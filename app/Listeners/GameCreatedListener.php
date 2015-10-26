<?php namespace DashboardersHeaven\Listeners;

use DashboardersHeaven\Events\GameCreated;
use GuzzleHttp\Client;

class GameCreatedListener
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  GameCreated $event
     *
     * @return void
     */
    public function handle(GameCreated $event)
    {
        $game     = $event->game;
        $titleId  = dechex($game->title_id);
        $response = $this->client->get('/v2/game-details-hex/' . $titleId);
        $gameData = head(data_get(json_decode((string) $response->getBody()), 'Items'));
        $game->update([
            'description'      => data_get($gameData, 'Description'),
            'shortDescription' => data_get($gameData, 'ReducedDescription'),
            'release_date'     => data_get($gameData, 'ReleaseDate'),
            'image_url'        => data_get($gameData, 'Images.0.Url'),
            'resize_image_url' => data_get($gameData, 'Images.0.ResizeUrl'),
        ]);
    }
}
