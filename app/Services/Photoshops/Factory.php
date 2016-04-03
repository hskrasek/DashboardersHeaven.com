<?php namespace DashboardersHeaven\Services\Photoshops;

use DashboardersHeaven\Photoshop;
use Illuminate\Http\Request;

class Factory
{
    public static function makeFromRequest(Request $request)
    {
        $photoshop = new Photoshop([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'gamer_id'    => $request->input('requestee'),
            'media'       => json_encode(array_map('trim', explode(PHP_EOL, $request->input('sources')))),
        ]);
        $photoshop->save();

        return $photoshop;
    }
}
