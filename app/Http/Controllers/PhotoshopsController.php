<?php

namespace DashboardersHeaven\Http\Controllers;

use DashboardersHeaven\Gamer;
use DashboardersHeaven\Http\Requests;
use DashboardersHeaven\Http\Requests\PhotoshopRequest;
use DashboardersHeaven\Photoshop;
use DashboardersHeaven\Services\Photoshops\Factory as PhotoshopFactory;

class PhotoshopsController extends Controller
{
    public function index()
    {
        $photoshops = Photoshop::with(['gamer'])->whereCompleted(true)->orderBy('created_at', 'desc')->get();

        return view('pages.photoshops.index', ['photoshops' => $photoshops]);
    }

    public function view($id)
    {
        $photoshop = Photoshop::find($id);

        return $photoshop->toJson();
    }

    public function requests()
    {
        $gamers = Gamer::select('id', 'gamertag')->get()->keyBy('id');

        return view('pages.photoshops.requests', ['gamers' => $gamers]);
    }

    public function saveRequest(PhotoshopRequest $request)
    {
        PhotoshopFactory::makeFromRequest($request);

        return redirect()->route('photoshops.requests');
    }
}
