<?php

namespace App\Http\Livewire\ListTickets;

use App\HistoryAvailability;
use App\Permission;
use App\Ticket;
use App\User;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ListTicketsDesignerManagerComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $designers, $search;

    public  function mount()
    {
        $permission = Permission::find(2);
        $this->designers = $permission->users()->where('status', 1)->get();
    }

    public function render()
    {
        $search = '%' . $this->search . '%';
        $tickets = Ticket::with(['ticketInformation' => function ($query) {
            $query->orWhere('ticket_informations.title', 'LIKE', '%' . $this->search . '%')->latest('created_at')
                ->limit(1);
        }])
            ->where('creator_name', 'LIKE', $search)
            ->orWhere('seller_name', 'LIKE', $search)->orWhere('designer_name', 'LIKE', $search)
            ->orWhereHas('ticketInformation', function ($query) use ($search) {
                $query->where('ticket_informations.title', 'LIKE', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')->paginate(15);
        return view('livewire.list-tickets.list-tickets-designer-manager-component', compact('tickets'));
    }

    function changeDesigner($designer_id, $ticket_id)
    {

        $ticket = Ticket::find($ticket_id);
        $actual = $ticket->designer_name;
        if ($ticket->designer_id == $designer_id) {
            return;
        }
        $designer = User::find($designer_id);
        $ticket->update([
            'designer_id' => $designer_id,
            'designer_name' => $designer->name . ' ' . $designer->lastname
        ]);
        try {
            HistoryAvailability::create([
                'info' => auth()->user()->name . " ha reasignado el ticket {$ticket->latestTicketInformation->title} <br>De {$actual} a " . $designer->name . ' ' . $designer->lastname,
                'user_id' => auth()->user()->id,
                'action' => 'reasignacion'
            ]);
        } catch (Exception $e) {
        }
        $this->dispatchBrowserEvent('designer-changed', [
            'name' => $designer->name . ' ' . $designer->lastname
        ]);
    }
}
