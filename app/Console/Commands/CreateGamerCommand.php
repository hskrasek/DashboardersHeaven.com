<?php

namespace DashboardersHeaven\Console\Commands;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Gamerscore;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class CreateGamerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamers:create {xuid : The XUID of the Gamer.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new gamer with initial data';
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

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
        $xuid = $this->argument('xuid');
        $this->info('Creating a new gamer for ' . $xuid);

        $response  = $this->client->get("v2/$xuid/gamercard");
        $gamercard = json_decode((string) $response->getBody());

        $response = $this->client->get("v2/$xuid/profile");
        $profile  = json_decode((string) $response->getBody());

        $gamer = Gamer::firstOrCreate([
            'xuid'            => $xuid,
            'gamertag'        => data_get($gamercard, 'gamertag'),
            'gamerpic_small'  => data_get($gamercard, 'gamerpicSmallSslImagePath'),
            'gamerpic_large'  => data_get($gamercard, 'gamerpicLargeSslImagePath'),
            'motto'           => data_get($gamercard, 'motto'),
            'bio'             => data_get($gamercard, 'bio'),
            'avatar_manifest' => data_get($gamercard, 'avatarManifest'),
            'gamerscore'      => $gamerscore = data_get($profile, 'Gamerscore'),
            'display_pic'     => data_get($profile, 'GameDisplayPicRaw'),
            'level'           => data_get($profile, 'TenureLevel'),
        ]);

        $gamer->gamerscores()->save(new Gamerscore([
            'score' => $gamerscore
        ]));

        $this->info('Created ' . $gamer->gamertag);

        $this->call('gamers:games', ['xuid' => $xuid]);

        $this->call('gamers:clips', ['xuid' => $xuid]);

        $this->call('gamers:screenshots', ['xuid' => $xuid]);
    }
}
