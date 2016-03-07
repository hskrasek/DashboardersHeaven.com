<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Http\Requests;
use DashboardersHeaven\Http\Requests\PhotoshopRequest;
use DashboardersHeaven\Photoshop;

class PhotoshopsController extends Controller
{
    public function index()
    {

    }

    public function requests()
    {
        $gamers = Gamer::select('id', 'gamertag')->get()->keyBy('id');

        return view('pages.photoshops.requests', ['gamers' => $gamers]);
    }

    public function saveRequest(PhotoshopRequest $request)
    {
        Photoshop::create([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'gamer_id'    => $request->input('requestee'),
            'media'       => json_encode(array_map('trim', explode(PHP_EOL, $request->input('sources')))),
        ]);

        return redirect('/');
    }
}
