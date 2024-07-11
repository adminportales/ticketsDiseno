<?php

namespace App\Http\Controllers;

use App\Role;
use App\TeamDiseno;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Log\TeamCity;

class TeamDisenoController extends Controller
{
    public function index()
    {
        $teamsdiseno = TeamDiseno::all();
        return view('administrador.teamsdiseno.index', compact('teamsdiseno'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$users = User::where('status', '=', '1')->get();
        //$users = User::with('whatRoles')->where('status', 1)->get();
        $users = User::with('whatRoles')
            ->where('status', 1)
            ->whereHas('whatRoles', function ($query) {
                $query->where('role_id', 3);
            })
            ->get();
        return view('administrador.teamsdiseno.create', compact('users'));
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

        $teamsdiseno = TeamDiseno::create([
            'name' => $request->name,
            'user_id' => $request->user,
            'role' => $request->role,
        ]);
        $hola = $teamsdiseno->membersDiseno()->attach(explode(',', $request->teamsdiseno));
        return $hola;
        return redirect()->action('TeamDisenoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(TeamDiseno $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    /*   public function edit(TeamDiseno $team)
    {
        $membersId = [];
        foreach ($team->members as $member) {
            array_push($membersId, $member->id);
        }
        $membersId = implode(",", $membersId);
        $users = User::where('status', '=', '1')->get();
        return view('administrador.teams.edit', compact('users', 'team', 'membersId'));
    } */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamDiseno $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamDiseno $teamsdiseno)
    {
        DB::table('team_diseno_user')->where('team_id', '=', $teamsdiseno->id)->delete();
        $teamsdiseno->delete();
        return redirect()->action('TeamDisenoController@index');
    }
}
