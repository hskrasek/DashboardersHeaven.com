<?php

namespace DashboardersHeaven\Console\Commands;

use Carbon\Carbon;
use DashboardersHeaven\Gamer;
use DashboardersHeaven\Screenshot;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateGamersScreenshotsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamers:screenshots {xuid : The XUID of the Gamer.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the gamers screenshots.';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \DashboardersHeaven\Gamer
     */
    protected $gamer;

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

        $this->getScreenshots($xuid);
    }

    private function getScreenshots($xuid)
    {
        $this->info('Getting the screenshots for ' . $xuid);

        $response    = $this->client->get("v2/$xuid/screenshots");
        $screenshots = json_decode((string) $response->getBody());

        if (!is_array($screenshots)) {
            $this->error('Unable to get screenshots for ' . $xuid);

            return;
        }

        foreach ($screenshots as $screenshot) {
            if (isset($screenshot->state) && $screenshot->state === "PendingUpload") {
                continue;
            }

            $screenshotData = $this->extractScreenshotData($screenshot);
            $screenshot     = Screenshot::whereScreenshotId($screenshotData['screenshot_id'])->first();

            if (!empty($screenshot)) {
                $screenshot->update($screenshotData);
                continue;
            }

            $this->gamer->screenshots()->save(new Screenshot($screenshotData));
        }
    }

    private function extractScreenshotData($data)
    {
        $clipData = [
            'screenshot_id'   => data_get($data, 'screenshotId'),
            'title_id'        => data_get($data, 'titleId'),
            'thumbnail_small' => data_get($data, 'thumbnails.0.uri'),
            'thumbnail_large' => data_get($data, 'thumbnails.1.uri'),
            'url'             => data_get($clip = $this->getClipUrl(data_get($data, 'screenshotUris')), 'uri'),
            'saved'           => (boolean) data_get($data, 'savedByUser'),
            'taken_at'        => data_get($data, 'dateTaken'),
            'expired'         => false,
            'expires_at'      => $expiresAt = Carbon::parse(data_get($clip, 'expiration')),
            'width'           => data_get($data, 'resolutionWidth'),
            'height'          => data_get($data, 'resolutionHeight'),
        ];

        $now = Carbon::now();

        if ($expiresAt->lt($now)) {
            $clipData['expired'] = true;
            \Log::notice('screenshot.expired', [
                'screenshot_id' => $clipData['screenshot_id'],
            ]);
        }

        return $clipData;
    }

    private function getClipUrl($uris)
    {
        $downloadUri = array_reduce($uris, function ($inital, $uri) {
            return ($uri->uriType == "Download") ? $uri : null;
        });

        return $downloadUri;
    }
}
