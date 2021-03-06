<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * Model of tournaments table.
 *
 * @author Dessaules Loïc
 */

class Tournament extends Model
{

    // I added this because when I try to save() Sport value an updated_At "xy" error appears
    // And with this that work
    public $timestamps = false;
    protected $fillable = array('name', 'start_date', 'end_date', 'start_time', 'event_id'); // -> We have to define all data we use on our sport table (For use ->all())
    protected $dates = ['start_date', 'end_date']; //need to user convert format date

    /**
     * Create a new belongs to relationship instance between Tournament and Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Doran Kayoumi
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Create a new belongs to relationship instance between Tournament and Sport
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author Doran Kayoumi
     */
    public function sport() {
        return $this->belongsTo('App\Sport');
    }

    /**
     * Create a new belongs to many relationship instance between Tournament and Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author Doran Kayoumi
     */
    public function teams() {
        return $this->hasMany('App\Team');
    }

    /**
     * Create a new belongs to many relationship instance between Tournament and Pool
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author Loïc Dessaules
     */
    public function pools() {
        return $this->hasMany('App\Pool');
    }

    /**
     * Get all active games of a tournament
     * @param  integer  $limit - number of games wanted
     * @return collection
     *
     * @author Doran Kayoumi
     */
    public function GetActiveGames($limit) {

        $tournament_games = new Collection();

        foreach ($this->pools as $pool) {

            $pool_games = new Collection();

            foreach ($pool->games as $game)
                if (is_null($game->score_contender1) && is_null($game->score_contender2)) $pool_games->push($game);

            $pool_games = Game::cleanEmptyContender($pool_games);

            if (count($pool_games) !== 0)
                $tournament_games = $tournament_games->merge($pool_games);
        }

        return $tournament_games->sortBy('start_time')->take($limit);
    }
}
