<?php

namespace App\Http\Livewire\ListTickets;

use App\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ListTicketsDesignerComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;


    public function render()
    {
        $search = '%' . $this->search . '%';
        $tickets = auth()->user()->assignedTickets()->with(['ticketInformation' => function ($query) {
            $query->orWhere('ticket_informations.title', 'LIKE', '%' . $this->search . '%')->latest('created_at')
                ->limit(1);
        }])
            ->where(function ($query) {
                $query->orWhere('creator_name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('seller_name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('ticketInformation', function ($query) use ($search) {
                $query->where('ticket_informations.title', 'LIKE', '%' . $this->search . '%');
            })
            ->where('designer_id', auth()->user()->id)
            ->orderByDesc('created_at')->paginate(15);
        return view('livewire.list-tickets.list-tickets-designer-component', compact('tickets'));
    }
}
