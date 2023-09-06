<?php

namespace App\Http\Livewire;

use App\Notifications\CancelReassignmentNotification;
use App\Notifications\ReasignarTicketNotification;
use App\Notifications\ReassignmentAcceptedNotification;
use App\User;
use Livewire\Component;

class ReassignTicketComponent extends Component
{
    public $ticket, $status_reassigned;

    public function render()
    {
        $users = User::join('permission_user', 'users.id', 'permission_user.user_id')
            ->where('permission_user.permission_id', 2)
            ->where('users.id', '!=', auth()->user()->id)
            ->where('users.status', 1)
            ->get();
        $this->status_reassigned = $this->ticket->latestTicketAssignProcess;
        return view('livewire.reassign-ticket-component', compact('users'));
    }

    // reasignarTicket
    public function reassignTicket($designer_id)
    {
        $traspaso = $this->ticket->ticketAssignProcess()->create([
            'ticket_id' => $this->ticket->id,
            'designer_id' => auth()->user()->id,
            'designer_name' => auth()->user()->name,
            'designer_received_id' => $designer_id,
            'designer_received_name' => User::find($designer_id)->name,
            'date_response' => null,
            'status' => 'En proceso de traspaso',
        ]);

        $this->ticket->historyTicket()->create([
            'ticket_id' => $this->ticket->id,
            'reference_id' => $traspaso->id,
            'type' => 'assigment'
        ]);

        //Notiticacion al usuario que recibe el ticket  
        $userReceivingReassignment = User::find($designer_id);
        $userReceivingReassignment->notify(new ReasignarTicketNotification(
            $this->ticket->designer_id,
            $this->ticket->latestTicketInformation->title,
            $this->ticket->designer_name
        ));

        $this->status_reassigned = $this->ticket->latestTicketAssignProcess;
        return ["message" => "OK"];
    }

    // cancelarReasignacion
    public function cancelReassign()
    {
        $traspaso = $this->ticket->ticketAssignProcess()->create([
            'ticket_id' => $this->ticket->id,
            'designer_id' => $this->status_reassigned->designer_id,
            'designer_name' => $this->status_reassigned->designer_name,
            'designer_received_id' => $this->status_reassigned->designer_received_id,
            'designer_received_name' => $this->status_reassigned->designer_received_name,
            'date_response' => now(),
            'status' => 'Rechazado',
        ]);

        $this->ticket->historyTicket()->create([
            'ticket_id' => $this->ticket->id,
            'reference_id' => $traspaso->id,
            'type' => 'assigment'
        ]);

        //Notiticacion de rechazo al usuario que envio el ticket
        $userReceivingReassignment = User::find($this->status_reassigned->designer_id);
        $userReceivingReassignment->notify(new CancelReassignmentNotification(
            $this->ticket->latestTicketInformation->title,
            $this->status_reassigned->designer_received_name
        ));

        $this->status_reassigned = $this->ticket->latestTicketAssignProcess;
        return ["message" => "OK"];
    }

    // aceptarReasignacion
    public function acceptReassign()
    {
        $traspaso = $this->ticket->ticketAssignProcess()->create([
            'ticket_id' => $this->ticket->id,
            'designer_id' => $this->status_reassigned->designer_id,
            'designer_name' => $this->status_reassigned->designer_name,
            'designer_received_id' => $this->status_reassigned->designer_received_id,
            'designer_received_name' => $this->status_reassigned->designer_received_name,
            'date_response' => now(),
            'status' => 'Aceptado',
        ]);

        $this->ticket->historyTicket()->create([
            'ticket_id' => $this->ticket->id,
            'reference_id' => $traspaso->id,
            'type' => 'assigment'
        ]);

        $this->ticket->designer_id = auth()->user()->id;
        $this->ticket->designer_name = auth()->user()->name . ' ' . auth()->user()->lastname;
        $this->ticket->save();

        //Notiticacion de aceptacion al usuario que envio el ticket

        $userReceivingReassignment = User::find($this->status_reassigned->designer_id);
        $userReceivingReassignment->notify(new ReassignmentAcceptedNotification(
            $this->ticket->latestTicketInformation->title, 
            $this->status_reassigned->designer_received_name));

        $this->status_reassigned = $this->ticket->latestTicketAssignProcess;
        return ["message" => "OK", "ticket_id" => $this->ticket->id];
    }
}
