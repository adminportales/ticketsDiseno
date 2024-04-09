<?php

namespace App\Http\Controllers;

use App\HistoryAvailability;
use App\Subtype;
use App\Ticket;
use App\TicketAssigment;
use App\Type;
use App\User;
use Exception;
use Illuminate\Http\Request;

class TicketAssigmentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:design_manager']);
    }

    public function changeDesigner(Request $request, Ticket $ticket)
    {
        $actual = $ticket->designer_name;
        if ($ticket->designer_id == $request->designer_id) {
            return response()->json('equalDesigner');
        }
        $ticket->update([
            'designer_id' => $request->designer_id,
            'designer_name' => $request->designer_name
        ]);
        try {
            HistoryAvailability::create([
                'info' => auth()->user()->name . " ha reasignado el ticket {$ticket->latestTicketInformation->title} <br>De {$actual} a " . $request->designer_name,
                'user_id' => auth()->user()->id,
                'action' => 'reasignacion'
            ]);
        } catch (Exception $e) {
        }

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
        $subtypes = Subtype::all();
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
        $text = '';
        foreach ($user->whatTypes as $type) {
            $text .= $type->type . ', ';
        }
        $user->whatTypes()->detach();
        $user->whatTypes()->attach($request->types);
        try {
            // Guardar dato en el HistoryAvailability
            $text1 = '';
            foreach ($user->whatTypes()->get() as $type) {
                $text1 .= $type->type . ', ';
            }
            HistoryAvailability::create([
                'info' => auth()->user()->name . " ha cambiado los tipos de tickets de {$user->name} <br>De " . $text . " a " . $text1,
                'user_id' => auth()->user()->id,
                'action' => 'configuracion'
            ]);
        } catch (Exception $e) {
        }

        return redirect()->action('DesignerManagerController@ticketAssign');
    }
}
