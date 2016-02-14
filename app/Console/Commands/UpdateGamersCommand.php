<?php

namespace DashboardersHeaven\Console\Commands;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Gamerscore;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateGamersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamers:update {xuid : The XUID of the Gamer.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the gamer with based on their gamercard and profile.';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \DashboardersHeaven\Gamer
     */
    private $gamer;

    /**
     * Create a new command instance.
     *
     * @param \GuzzleHttp\Client $client
     */
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
        $xuid        = $this->argument('xuid');
        $this->gamer = Gamer::whereXuid($xuid)->first();
        $this->getGamercard($xuid);
        $this->getProfile($xuid);
    }

    private function getGamercard($xuid)
    {
        $this->info("Getting the gamercard data for {$this->gamer->gamertag} ($xuid)");

        $response  = $this->client->get("v2/$xuid/gamercard");
        $gamercard = json_decode((string) $response->getBody());

        $this->gamer->update([
            'gamerpic_small'  => data_get($gamercard, 'gamerpicSmallSslImagePath'),
            'gamerpic_large'  => data_get($gamercard, 'gamerpicLargeSslImagePath'),
            'motto'           => data_get($gamercard, 'motto'),
            'bio'             => data_get($gamercard, 'bio'),
            'avatar_manifest' => data_get($gamercard, 'avatarManifest'),
        ]);
    }

    private function getProfile($xuid)
    {
        $this->info('Getting the profile data for ' . $xuid);

        $response = $this->client->get("v2/$xuid/profile");
        $profile  = json_decode((string) $response->getBody());

        $this->gamer->update([
            'gamerscore'  => data_get($profile, 'Gamerscore'),
            'display_pic' => data_get($profile, 'GameDisplayPicRaw'),
            'level'       => data_get($profile, 'TenureLevel'),
        ]);

        $score = data_get($profile, 'Gamerscore');

        if (!empty($score)) {
            $this->gamer->gamerscores()->save(new Gamerscore([
                'score' => $score
            ]));
        }
    }
}
