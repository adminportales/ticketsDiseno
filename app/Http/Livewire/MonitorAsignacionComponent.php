<?php

namespace App\Http\Livewire;

use App\Role;
use App\TicketAssigment;
use App\Type;
use App\User;
use Livewire\Component;

class MonitorAsignacionComponent extends Component
{
    public function render()
    {
        $types = Type::all();
        $designersAssigments = [];
        foreach ($types as $type) {
            $designerAssigments = TicketAssigment::join('users', 'ticket_assigments.designer_id', '=', 'users.id')
                ->join('profiles', 'ticket_assigments.designer_id', '=', 'profiles.user_id')
                ->where('ticket_assigments.type_id', '=', $type->id)->where('users.status', '=', 1)
                ->where('profiles.availability', '=', 1)
                ->select("users.name", "ticket_assigments.designer_id")->get();
            $designer = $this->checkWorkload($designerAssigments);
            array_push($designersAssigments, [
                "designers" => $designerAssigments->toArray(),
                'type' => $type->type,
                'designer' => $designer,
            ]);
        }
        return view('livewire.monitor-asignacion-component', compact('designersAssigments'));
    }

    public function checkWorkload($designerAssigments)
    {
        $dataToFilters = [];
        /*
           Revisar si hay cero diseñadores que pueden recibir este tipo de ticket
           En este caso asignarlo al gerente de diseño y que el lo reasigne si desea
        */
        if (count($designerAssigments) <= 0) {
            $designer = Role::find(5)->whatUsers;
            $dataToFilters = [
                'designer' => $designer[0],
                "msg" => "No hay diseñadores disponibles para este tipo de ticket. Se asigno al gerente de diseño Filtro 1"
            ];
            return $dataToFilters;
        }
        /*
            Si solo hay un diseñador que recibe ese ticket, asignar el ticket a ese diseñador
            Si no esta disponible por que falto o algo, asignarselo al gerente de diseño
        */
        if (count($designerAssigments) == 1) {
            $designerAssigment = User::find($designerAssigments[0]->designer_id);
            if ($designerAssigment->profile->availability) {
                $dataToFilters = [
                    'designer' => $designerAssigment,
                    "msg" => "El diseñador asignado esta disponible. Se asigno al diseñador Filtro 2"
                ];
                return $dataToFilters;
            } else {
                $designer = Role::find(5)->whatUsers;
                $dataToFilters = [
                    'designer' => $designer[0],
                    "msg" => "El diseñador asignado no esta disponible. Se asigno al gerente de diseño Filtro 2"
                ];
                return $dataToFilters;
            }
        } else {
            /*
                Si hay mas de un diseñador que pueda atender este ticket
                Revisamos las disponibilidad
            */
            $data = [];
            // Crear un arreglo para guardar el total de tickets que no estan finalizados
            foreach ($designerAssigments as $key => $designerAssigment) {
                $designer = User::find($designerAssigment->designer_id);

                $totalTickets = 0;
                $timeWait = 0;
                // Vamos a considerar al diseñador siempre y cuando este disponible
                if ($designer->profile->availability) {
                    $ticketsAsignados = $designer->assignedTickets->where('status_id', '!=', '3')->where('status_id', '!=', '6')->where('updated_at', '>', now()->subHours(16));
                    foreach ($ticketsAsignados  as $ticket) {
                        if (strpos($ticket->designer_name, $designer->name) !== false) {
                            $totalTickets++;
                        }
                    }
                    $data[$key] = [
                        'designer' => $designer,
                        'total' => $totalTickets,
                        'time' => $timeWait,
                    ];
                }
            }

            // Si no hay diseñadores disponibles, se asignan al gerente de diseño
            if (count($data) <= 0) {
                $designer = Role::find(5)->whatUsers;
                $dataToFilters = [
                    'designer' => $designer[0],
                    "data" => $data,
                    "msg" => "No hay diseñadores disponibles para este tipo de ticket. Se asigno al gerente de diseño Filtro 3"
                ];
                return $dataToFilters;
            }

            //Si el numero de tickets es el mismo, asignalos aleatoreamemte
            //Si no, regresa el que tenga el menor numero de tickets asignados
            for ($j = 0; $j < count($data) - 1; $j++) {
                for ($i = 0; $i < count($data) - 1; $i++) {
                    if ($data[$i]['total'] > $data[$i + 1]['total']) {
                        $aux = $data[$i];
                        $data[$i] = $data[$i + 1];
                        $data[$i + 1] = $aux;
                    }
                }
            }

            $newData = [$data[0]];
            for ($i = 1; $i < count($data); $i++) {
                if ($data[0]['total'] === $data[$i]['total']) {
                    array_push($newData, $data[$i]);
                } else {
                    break;
                }
            }
            if (count($newData) == 1) {
                $dataToFilters = [
                    'designer' => $newData[0]['designer'],
                    "data" => $data,
                    "newData" => $newData,
                    "msg" => "Se asigno al diseñador con menos tickets asignados Filtro 4"
                ];
                return $dataToFilters;
            } else {
                //TODO: Retornar a la persona que lleva mas tiempo si entregar un ticket
                $lastestTicket = [];
                foreach ($newData as $desNew) {
                    $lastT =  $desNew['designer']->assignedTickets()->whereIn('status_id', [2,3,5])->orderBy('updated_at', 'desc')->first();
                    array_push($lastestTicket, $lastT);
                }

                for ($j = 0; $j < count($lastestTicket) - 1; $j++) {
                    for ($i = 0; $i < count($lastestTicket) - 1; $i++) {
                        if ($lastestTicket[$i]->updated_at > $lastestTicket[$i + 1]->updated_at) {
                            $aux = $lastestTicket[$i];
                            $lastestTicket[$i] = $lastestTicket[$i + 1];
                            $lastestTicket[$i + 1] = $aux;
                        }
                    }
                }
                $dataToFilters = [
                    'designer' => User::find($lastestTicket[0]->designer_id),
                    "data" => $data,
                    "newData" => $newData,
                    "lastestTicket" => $lastestTicket,
                    "msg" => "Se asigno al diseñador con mas tiempo sin actividad Filtro 5"
                ];
                return $dataToFilters;
            }
        }
    }
}
