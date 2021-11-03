<?php

namespace App\Http\Controllers;

use App\Notifications\RegisteredUser;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByRaw('status DESC')->get();
        //$users = User::where('status', 1);
        return view('administrador.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('administrador.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required'],
        ]);

        // Crear una contraseña aleatoria
        $pass = Str::random(8);

        // Registrar el usuario
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($pass)
        ]);
        $user->profile()->update([
            'company' => $request->company
        ]);

        // Asignar el rol seleccionado
        $role = Role::find($request->role);
        $user->attachRole($role);

        // Enviar notificacion de registro
        $dataNotification = [
            'name' => $request->name . ' ' . $request->lastname,
            'email' => $request->email,
            'password' => $pass,
            'role' => $role->display_name
        ];
        $user->notify(new RegisteredUser($dataNotification));

        // Mostrar la lista de usuarios
        return redirect()->action('UserController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('administrador.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Validar los datos
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company' => ['required', 'string', 'max:255'],
        ]);

        // Actualizar el usuario
        $user->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'company' => $request->company
        ]);
        $user->profile->create(['company' => $request->company]);

        // Retornar a la vista
        return redirect()->action('UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    /**Eliminar usuario */
    public function destroy(User $user)
    {
        $user->update(['status' => false]);
        return redirect()->action('UserController@index');
    }

    public function import(Request $request)
    {
        $excel = $request->file('excel');
        $rutaArchivo = public_path('storage/excel/') . $excel->getClientOriginalName();
        $excel->move(public_path('storage/excel'), $excel->getClientOriginalName());
        echo $rutaArchivo;
        $documento = IOFactory::load($rutaArchivo);


        // Proceso de importacion
        $documento = IOFactory::load($rutaArchivo);

        //obtener conteo e iterar
        $totalDeHojas = $documento->getSheetCount();
        //Eliminarr ese archivo

        //return redirect()->action('UserController@index');

    }
    public function sample(User $user)
    {
        return view('administrador.import');
    }
}
