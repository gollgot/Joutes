<?php

namespace App\Http\Controllers;

use App\Tournament;
use App\Sport;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    /**
     * Display a listing of the tournaments.
     *
     * @return \Illuminate\Http\Response
     *
     * @author Dessaules Loïc
     */
    public function index()
    {
        $tournaments = Tournament::all();
        return view('tournament.index', array(
            "tournaments" => $tournaments,
            "fromEvent" => false
        ));
    }

    /**
     * Display the specified tournament.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @author Dessaules Loïc
     */
    public function show($id)
    {
        $tournament = Tournament::find($id);
        return view('tournament.show')->with('tournament', $tournament);
    }
}
