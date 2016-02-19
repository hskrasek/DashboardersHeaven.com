<?php namespace DashboardersHeaven\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Response;

class AjaxController extends Controller
{
    public function gamerscores(Request $request, $gamerId)
    {
        $now      = Carbon::now()->endOfDay();
        $lastWeek = (clone $now);
        $lastWeek->subWeek(1)->startOfDay();
        $gamerscores = DB::table('gamerscores')
                         ->select(DB::raw('MAX(score) as count, DATE(created_at) as date'))
                         ->where('gamer_id', $gamerId)
//                         ->whereBetween('created_at', [$lastWeek->toDateTimeString(), $now->toDateTimeString()])
                         ->groupBy(DB::raw('DATE(created_at)'))
                         ->orderBy('created_at', 'ASC')
                         ->get();

        return Response::json([
            'x'          => array_pluck($gamerscores, 'date'),
            'gamerscore' => array_pluck($gamerscores, 'count'),
        ]);
    }
}
