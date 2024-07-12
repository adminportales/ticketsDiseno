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
        $list_users_ventas = User::where('status', '=', '1')->get();
        $users = User::with('whatRoles')
            ->where('status', 1)
            ->whereHas('whatRoles', function ($query) {
                $query->where('role_id', 3);
            })
            ->get();
        return view('administrador.teamsdiseno.create', compact('users', 'list_users_ventas'));
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
        ]);
        $teamsdiseno = TeamDiseno::create([
            'name' => $request->name,
            'user_id' => $request->user,
            'role' => 0,
        ]);
        $team = implode(",", $request->team);
        $teamsdiseno->membersDiseno()->attach(explode(',', $team));
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
    public function edit(TeamDiseno $teamsdiseno, Request $request)
    {
        $membersId = [];
        foreach ($teamsdiseno->membersDiseno as $member) {
            array_push($membersId, $member->id);
        }
        $membersId = implode(",", $membersId);
        $users_diseño = User::with('whatRoles')
            ->where('status', 1)
            ->whereHas('whatRoles', function ($query) {
                $query->where('role_id', 3);
            })
            ->get();

        $users = User::where('status', '=', '1')->get();
        return view('administrador.teamsdiseno.edit', compact('users', 'teamsdiseno', 'membersId', 'users_diseño'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamDiseno $teamsdiseno)
    {
        // Validar y procesar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|exists:users,id',
            'team' => 'nullable|array', // Asegura que team sea un array
        ]);
        // Actualizar el equipo
        $teamsdiseno->update([
            'name' => $request->name,
            'user_id' => $request->user,
        ]);
        // Sync members
        if ($request->has('team')) {
            $teamsdiseno->membersDiseno()->sync($request->team); // Utiliza sync() en lugar de attach()
        } else {
            $teamsdiseno->membersDiseno()->sync([]); // Para limpiar los miembros si no se selecciona ninguno
        }
        return redirect()->route('teamsdiseno.index')->with('success', 'Equipo actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamDiseno $teamsdiseno)
    {
        DB::table('team_diseno_user')->where('team_diseno_id', '=', $teamsdiseno->id)->delete();
        $teamsdiseno->delete();
        return redirect()->action('TeamDisenoController@index');
    }
}
