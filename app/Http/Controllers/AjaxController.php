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
        $sub = DB::table('gamerscores')
                 ->select(DB::raw('score as score, DATE(created_at) as date'))
                 ->where('gamer_id', $gamerId)
                 ->groupBy(DB::raw('DATE(created_at)'))
                 ->orderBy('created_at', 'DESC');

        $gamerscores = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                         ->mergeBindings($sub)
                         ->groupBy('score')
                         ->get();

        return Response::json([
            'x'          => $gamerscores->pluck('date'),
            'gamerscore' => $gamerscores->pluck('score'),
        ]);
    }
}
