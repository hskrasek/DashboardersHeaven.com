<?php

namespace DashboardersHeaven;

use Illuminate\Database\Eloquent\Model;

/**
 * DashboardersHeaven\Screenshot
 *
 * @property integer                       $id
 * @property integer                       $gamer_id
 * @property string                        $screenshot_id
 * @property integer                       $title_id
 * @property integer                       $width
 * @property integer                       $height
 * @property string                        $thumbnail_small
 * @property string                        $thumbnail_large
 * @property string                        $url
 * @property boolean                       $saved
 * @property boolean                       $expired
 * @property string                        $expires_at
 * @property string                        $taken_at
 * @property \Carbon\Carbon                $created_at
 * @property \Carbon\Carbon                $updated_at
 * @property-read Gamer                    $gamer
 * @property-read \DashboardersHeaven\Game $game
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereGamerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereScreenshotId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereTitleId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereThumbnailSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereThumbnailLarge($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereSaved($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereExpired($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereExpiresAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereTakenAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Screenshot whereUpdatedAt($value)
 */
class Screenshot extends Model
{
    protected $table = 'screenshots';

    protected $fillable = [
        'gamer_id',
        'screenshot_id',
        'title_id',
        'width',
        'height',
        'thumbnail_small',
        'thumbnail_large',
        'url',
        'saved',
        'expired',
        'taken_at',
        'expires_at'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'title_id', 'title_id');
    }

    public function gamer()
    {
        return $this->belongsTo(Gamer::class, 'gamer_id', 'id');
    }
}
