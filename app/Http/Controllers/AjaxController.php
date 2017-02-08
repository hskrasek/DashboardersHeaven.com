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
                 ->groupBy(DB::raw('DATE(created_at)'), 'score')
                 ->orderBy(DB::raw('DATE(created_at)'), 'DESC')
                 ->orderBy('score', 'DESC');

        $gamerscores = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                         ->mergeBindings($sub)
                         ->groupBy('score', 'date')
                         ->get();

        $gamerscores = $gamerscores->groupBy(function ($gamerscore) {
            return Carbon::parse($gamerscore->date)->year;
        })->transform(function ($yearCollection) {
            /** @var \Illuminate\Support\Collection $yearCollection */
            return $yearCollection->groupBy(function ($gamerscore) {
                return Carbon::parse($gamerscore->date)->month;
            })->map(function ($monthCollection) {
                /** @var \Illuminate\Support\Collection $monthCollection */
                return $monthCollection->sortByDesc('date')->first();
            });
        })->collapse()->keyBy(function ($value, $_) {
            return $value->date;
        })->map(function ($value) {
            return $value->score;
        });

        return Response::json([
            'x'          => $gamerscores->keys(),
            'gamerscore' => $gamerscores->values(),
        ]);
    }
}
