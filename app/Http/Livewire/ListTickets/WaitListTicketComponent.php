<?php

namespace App\Http\Livewire\ListTickets;

use App\Events\ChangeStatusSendEvent;
use App\Notifications\ChangeStatusNotification;
use App\Status;
use App\Ticket;
use App\User;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class WaitListTicketComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ticket;

    public function render()
    {
        $tickets = Ticket::where('designer_id', null)
            ->orderByDesc('created_at')->paginate(15);
        return view('livewire.list-tickets.wait-list-ticket-component',  compact('tickets'));
    }
    // show ticket
    public function showTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->dispatchBrowserEvent('showTicket');
    }

    // assign ticket
    public function assignTicket()
    {
        try {
            $this->ticket->designer_id = auth()->user()->id;
            $this->ticket->designer_name = auth()->user()->name . " " . auth()->user()->lastname;
            $this->ticket->save();
            $status = Status::find(2);
            $statusChange = $this->ticket->statusChangeTicket()->create([
                'status_id' => $status->id,
                'status' => $status->status
            ]);
            $this->ticket->historyTicket()->create([
                'ticket_id' => $this->ticket->id,
                'reference_id' => $statusChange->id,
                'type' => 'status'
            ]);
            $this->ticket->status_id = $statusChange->status_id;
            $this->ticket->save();

            $transmitter_name = auth()->user()->name . ' ' . auth()->user()->lastname;
            $userReceiver = '';
            if (auth()->user()->isAbleTo(['attend-ticket'])) {
                $userReceiver = User::find($this->ticket->creator_id);
            } else if (auth()->user()->isAbleTo(['create-ticket'])) {
                $userReceiver = User::find($this->ticket->designer_id);
            }
            $receiver_id = $userReceiver->id;
            try {
                event(new ChangeStatusSendEvent($this->ticket->latestTicketInformation->title, $status->status, $receiver_id, $transmitter_name));
                $userReceiver->notify(new ChangeStatusNotification($this->ticket->id, $this->ticket->latestTicketInformation->title, $transmitter_name, $status->status));
            } catch (Exception $th) {
                return 2;
            }
            return [1, $this->ticket->id];
        } catch (Exception $e) {
            return 2;
        }
    }
}
