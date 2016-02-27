<?php

namespace DashboardersHeaven\Console\Commands;

use Carbon\Carbon;
use DashboardersHeaven\Game;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateGamesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates games missing extended data';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $updatedGames = 0;
        $this->info('Updating games...');
        $games = Game::all();
        foreach ($games as $game) {
            if (empty($game->description)) {
                $this->updateGame($game);
                $updatedGames++;
            }
        }

        $this->info("Updated $updatedGames games");
    }

    private function updateGame(Game $game)
    {
        $titleId  = dechex($game->title_id);
        $response = $this->client->get('/v2/game-details-hex/' . $titleId);
        $gameData = head(data_get(json_decode((string) $response->getBody()), 'Items', []));

        if (empty($gameData)) {
            $this->warn("Failed to update {$game->title}");
        }

        $game->update([
            'description'      => data_get($gameData, 'Description'),
            'shortDescription' => data_get($gameData, 'ReducedDescription'),
            'release_date'     => Carbon::parse(data_get($gameData, 'ReleaseDate')),
            'image_url'        => data_get($gameData, 'Images.0.Url'),
            'resize_image_url' => data_get($gameData, 'Images.0.ResizeUrl'),
        ]);
    }
}
