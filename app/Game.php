<?php namespace DashboardersHeaven;

use Illuminate\Database\Eloquent\Model;

/**
 * DashboardersHeaven\Game
 *
 * @property integer                                                                   $id
 * @property integer                                                                   $title_id
 * @property string                                                                    $title
 * @property boolean                                                                   $is_app
 * @property \Carbon\Carbon                                                            $created_at
 * @property \Carbon\Carbon                                                            $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\DashboardersHeaven\Gamer[] $gamers
 * @property-read \Illuminate\Database\Eloquent\Collection|\DashboardersHeaven\Clip[]  $clips
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereTitleId($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereUpdatedAt($value)
 * @property string                                                                    $description
 * @property string                                                                    $short_description
 * @property string                                                                    $image_url
 * @property string                                                                    $resize_image_url
 * @property \Carbon\Carbon                                                            $release_date
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereShortDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereResizeImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereIsApp($value)
 * @method static \Illuminate\Database\Query\Builder|\DashboardersHeaven\Game whereReleaseDate($value)
 */
class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'title_id',
        'title',
        'earned_achievements',
        'current_gamerscore',
        'max_gamerscore',
        'last_unlock',
        'description',
        'short_description',
        'image_url',
        'resize_image_url',
        'release_date',
    ];

    protected $dates = [
        'release_date'
    ];

    public function gamers()
    {
        return $this->belongsToMany(\DashboardersHeaven\Gamer::class)
                    ->withPivot([
                        'earned_achievements',
                        'current_gamerscore',
                        'max_gamerscore',
                        'last_unlock'
                    ])
                    ->withTimestamps();
    }

    /**
     * Get all the clips that recorded in this game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clips()
    {
        return $this->hasMany(\DashboardersHeaven\Clip::class, 'title_id', 'title_id');
    }

    /**
     * {@inheritdoc}
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        return new GamesGamersPivot($parent, $attributes, $table, $exists);
    }
}
