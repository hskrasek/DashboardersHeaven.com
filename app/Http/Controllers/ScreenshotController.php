<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Http\Requests;
use DashboardersHeaven\Screenshot;
use Illuminate\Http\Request;

class ScreenshotController extends Controller
{
    public function index()
    {
        $clips = Screenshot::with(['game', 'gamer'])->orderBy('taken_at', 'desc')->paginate(16);

        if (!$clips) {
            app()->abort(404); //TODO: Probably make this better, maybe?
        }

        return view('pages.screenshots.index', ['screenshots' => $clips]);
    }

    public function screenshot(Request $request, $screenshotId)
    {
        $screenshot = Screenshot::with(['game', 'gamer'])->whereScreenshotId($screenshotId)->first();

        if (!$screenshot) {
            app()->abort(404);
        }

        return view('pages.screenshots.screenshot', ['gamer' => $screenshot->gamer, 'screenshot' => $screenshot]);
    }

    public function screenshotsForGamertag(Request $request, $gamertag)
    {
        $gamer = Gamer::whereGamertag($gamertag)->first();

        if (!$gamer) {
            app()->abort(404);
        }

        $screenshots = Screenshot::with('game')->whereHas('gamer', function ($query) use ($gamer) {
            $query->where('gamer_id', '=', $gamer->id);
        })->orderBy('taken_at', 'desc')->paginate(16);

        return view('pages.gamers.screenshots', ['gamer' => $gamer, 'screenshots' => $screenshots]);
    }

    public function screenshotForGamertag(Request $request, $gamertag, $screenshotId)
    {
        $gamer      = Gamer::whereGamertag($gamertag)->first();
        $screenshot = Screenshot::with('game')->whereScreenshotId($screenshotId)->first();

        if (!$gamer || !$screenshot) {
            app()->abort(404);
        }

        return view('pages.screenshots.screenshot', ['screenshot' => $screenshot, 'gamer' => $gamer]);
    }
}
