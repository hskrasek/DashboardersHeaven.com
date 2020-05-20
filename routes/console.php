<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('destiny:signoff', function () {
    $response = (new \GuzzleHttp\Client())->post('https://slack.com/api/chat.postMessage', [
        'headers' => [
            'Authorization' => 'Bearer ' . env('SLACK_API_TOKEN'),
        ],
        'json'    => [
            // 'channel' => 'G622FQ124',
            'channel' => 'C70TKFLKZ',
            'text'    => 'My battery is low and it\'s getting dark. Goodbye',
        ],
    ]);
    dd(json_decode((string) $response->getBody(), true));
});
