<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return view('administrador.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('status', '=', '1')->get();
        return view('administrador.teams.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'user' => ['required', 'string', 'max:255'],
            'team' => 'required',
            'role' => 'required',
        ]);
        $team = Team::create([
            'name' => $request->name,
            'user_id' => $request->user,
            'role' => $request->role,
        ]);
        $team->members()->attach(explode(',', $request->team));
        return redirect()->action('TeamController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $membersId = [];
        foreach ($team->members as $member) {
            array_push($membersId, $member->id);
        }
        $membersId = implode(",", $membersId);
        $users = User::where('status', '=', '1')->get();
        return view('administrador.teams.edit', compact('users', 'team', 'membersId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        DB::table('team_user')->where('team_id', '=', $team->id)->delete();
        $team->delete();
        return redirect()->action('TeamController@index');
    }
}
