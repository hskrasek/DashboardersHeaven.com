<?php namespace DashboardersHeaven;

use Illuminate\Database\Eloquent\Model;

/**
 * DashboardersHeaven\Gamerscore
 *
 * @property integer                        $id
 * @property integer                        $gamer_id
 * @property integer                        $score
 * @property \Carbon\Carbon                 $created_at
 * @property \Carbon\Carbon                 $updated_at
 * @property-read \DashboardersHeaven\Gamer $gamer
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Gamerscore whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Gamerscore whereGamerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Gamerscore whereScore($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Gamerscore whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Gamerscore whereUpdatedAt($value)
 */
class Gamerscore extends Model
{
    protected $table = 'gamerscores';

    protected $fillable = [
        'gamer_id',
        'score',
    ];

    /**
     * Get the gamer for a gamerscore.
     *
     */
    public function gamer()
    {
        $this->belongsTo(\DashboardersHeaven\Gamer::class);
    }
}
