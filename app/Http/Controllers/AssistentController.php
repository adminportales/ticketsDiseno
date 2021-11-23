<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssistentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static function dashboard()
    {
        // traemos los tickets que el vendedor creo, traemos su estado
        $members = auth()->user()->team->members;
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->paginate(5);
        $totalTickets = 0;
        $closedTickets = 0;
        $openTickets = 0;
        $ticketsSellers=[];

        foreach ($tickets as $ticket) {
            $statusTicket = $ticket->latestStatusChangeTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }

        foreach ($members as $member ) {
            $ticketsMember = [
                'seller' => $member,
                'tickets' => $member->ticketsCreated()->paginate(5)
            ];
            array_push($ticketsSellers,$ticketsMember);
        }

        return view('assistent.dashboard',compact('tickets', 'ticketsSellers', 'totalTickets', 'closedTickets', 'openTickets'));
    }
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
