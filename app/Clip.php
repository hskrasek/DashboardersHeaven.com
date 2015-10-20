<?php namespace DashboardersHeaven;

use Illuminate\Database\Eloquent\Model;

/**
 * DashboardersHeaven\Clip
 *
 * @property integer                       $id
 * @property string                        $clip_id
 * @property integer                       $title_id
 * @property integer                       $xuid
 * @property string                        $name
 * @property string                        $game_title
 * @property string                        $thumbnail_small
 * @property string                        $thumbnail_large
 * @property string                        $url
 * @property boolean                       $saved
 * @property string                        $recorded_at
 * @property \Carbon\Carbon                $created_at
 * @property \Carbon\Carbon                $updated_at
 * @property-read \DashboardersHeaven\Game $game
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereClipId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereTitleId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereXuid($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereThumbnailSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereThumbnailLarge($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereSaved($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereRecordedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Clip whereUpdatedAt($value)
 */
class Clip extends Model
{
    protected $table = 'clips';

    protected $fillable = [
        'clip_id',
        'title_id',
        'name',
        'game_title',
        'xuid',
        'thumbnail_small',
        'thumbnail_large',
        'url',
        'saved',
        'recorded_at',
        'expired'
    ];

    protected $dates = [
        'recorded_at'
    ];

    /**
     * Get the game this clip was recorded in
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('DashboardersHeaven\Game', 'title_id', 'title_id');
    }

    /**
     * Get all the gamers clips
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gamer()
    {
        return $this->hasMany('DashboardersHeaven\Gamer', 'xuid', 'xuid');
    }
}
