<?php
namespace App\Http\Response\Transformers;

use App\Tournament;
use League\Fractal\TransformerAbstract;

class SingleTournamentTransformer extends TransformerAbstract
{
    public $defaultIncludes = [
        "teams"
    ];

    public function transform(Tournament $tournament) {

        return [
            'id'            => (int) $tournament->id,
            'name'          => (string) $tournament->name,
            'sport'         => (string) $tournament->sport->name,
            'type'          => '',
            'place'         => '',
            'winner'        => [],
            'second'        => [],
            'third'         => [],
            'group_matches' => [],
            'stages'        => [],
        ];
    }

    public function includeTeams(Tournament $tournament) {
        return $this->collection($tournament->teams, new TournamentTeamTransformer);
    }
}
