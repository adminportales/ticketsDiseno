<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketAssigment;
use App\Type;
use App\User;
use Illuminate\Http\Request;

class TicketAssigmentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:design_manager']);
    }

    public function changeDesigner(Request $request, Ticket $ticket)
    {
        if ($ticket->designer_id == $request->designer_id) {
            return response()->json('equalDesigner');
        }
        $ticket->update([
            'designer_id' => $request->designer_id,
            'designer_name' => $request->designer_name
        ]);
        return response()->json(['name' => $request->designer_name]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketAssigment  $ticketAssigment
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $types = Type::all();
        $userTypes = $user->whatTypes;
        return view('design_manager.ticketAssigment.edit', compact('types', 'user', 'userTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketAssigment  $ticketAssigment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->whatTypes()->detach();
        $user->whatTypes()->attach($request->types);
        return redirect()->action('DesignerManagerController@ticketAssign');
    }
}
