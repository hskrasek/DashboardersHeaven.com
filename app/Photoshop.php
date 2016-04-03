<?php

namespace DashboardersHeaven;

use Illuminate\Database\Eloquent\Model;

/**
 * DashboardersHeaven\Photoshop
 *
 * @property integer        $id
 * @property integer        $gamer_id
 * @property string         $title
 * @property string         $description
 * @property string         $media
 * @property string         $uri
 * @property boolean        $completed
 * @property string         $completed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereGamerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereMedia($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereUri($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereCompletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Photoshop whereUpdatedAt($value)
 */
class Photoshop extends Model
{
    protected $fillable = [
        'gamer_id',
        'title',
        'description',
        'media',
        'completed',
        'completed_at',
        'uri'
    ];

    protected $casts = [
        'media' => 'array'
    ];

    public function gamer()
    {
        return $this->belongsTo(Gamer::class);
    }
}
