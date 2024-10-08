<?php

namespace App\Http\Controllers;

use App\Events\ChangeTicketSendEvent;
use App\Events\TicketCreateSendEvent;
use App\HistoryAvailability;
use App\Notifications\TicketChangeNotification;
use App\Notifications\TicketCreateNotification;
use App\Notifications\TicketDeliveryNotification;
use App\Notifications\TicketUpdate;
use App\Events\TicketDeliverySendEvent;
use App\Events\TicketUpdateSendEvent;
use App\Priority;
use App\Role;
use App\Status;
use App\Subtype;
use App\Technique;
use App\Ticket;
use App\TicketAssigment;
use App\Type;
use App\User;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*         $user = User::find(auth()->user()->id);
        // Obtener los tickets del vendedor y de su asistente
        // Si es vendedor, quien es my asistente y si es asistente, a quien asiste
        // $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        $ticketsAll = '';
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        if ($user->hasRole('sales_assistant')) {
            $members = $user->team->members;
            foreach ($members as $member) {
                dd($member->ticketsCreated);
                $ticketsAll = $member->ticketsCreated->union($tickets);
            }
        } else {
        }
        dd($ticketsAll);
        return; */
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        // Obtener los ticktes del asistente y se sus ejecutivos

        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        $priorities = Priority::all();

        return view('seller.tickets.index', compact('tickets', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $subtypes = Subtype::all();
        $techniques = Technique::all();
        return view('seller.tickets.create', compact('types', 'techniques', 'subtypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Obtener el id y el nombre del vendedor o asistente que esta editando
        $userCreator = User::find(auth()->user()->id);
        $creator_id = $userCreator->id;
        $creator_name = $userCreator->name . ' ' . $userCreator->lastname;
        request()->validate([
            'type' => 'required',
        ]);
        switch ($request->type) {
            case 1:
                request()->validate([
                    'title' => ['required', 'string', 'max:191'],
                    'type' => 'required',
                    'technique' => 'required',
                    'position' => ['required', 'string', 'max:191'],
                    'pantone' => ['required', 'string', 'max:191'],
                    'description' => ['required', 'string', 'max:60000'],
                    'logo' => 'required',
                    'product' => 'required',
                    'position' => 'required',
                    'customer' => ['required', 'string', 'max:191'],
                    'samples' => ['required']
                ]);
                $request->companies = null;
                $request->subtype = null;
                $request->measures = null;
                break;
            case 2:
                request()->validate([
                    'type' => 'required',
                    'title' => ['required', 'string', 'max:191'],
                    'customer' => ['required', 'string', 'max:191'],
                    'companies' => ['required'],
                    'description' => ['required', 'string', 'max:60000'],
                    'logo' => 'required',
                    'items' => 'required',
                ]);
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->subtype = null;
                $request->measures = null;
                $request->samples = null;
                break;

            case 3:
                request()->validate([
                    'type' => 'required',
                    'title' => ['required', 'string', 'max:191'],
                    'description' => ['required', 'string', 'max:60000'],
                    'items' => 'required',
                    'samples' => ['required']
                ]);
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->logo = null;
                $request->customer = null;
                $request->companies = null;
                $request->measures = null;
                $request->subtype = null;
                break;
            case 4:
                request()->validate([
                    'type' => 'required',
                    'title' => ['required', 'string', 'max:191'],
                    'customer' => ['required', 'string', 'max:191'],
                    'description' => ['required', 'string', 'max:60000'],
                    'items' => 'required',
                ]);
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->logo = null;
                $request->companies = null;
                $request->measures = null;
                $request->subtype = null;
                $request->samples = null;
                break;
            case 5:
                request()->validate([
                    'title' => ['required', 'string', 'max:191'],
                    'companies' => ['required'],
                    'samples' => ['required'],
                    'type' => 'required',
                    'description' => ['required', 'string', 'max:60000'],
                    'logo' => 'required',
                    'product' => 'required',
                    'customer' => ['required', 'string', 'max:191'],
                    'measures' => 'required'
                ]);
                $request->technique = null;
                $request->position = null;
                $request->pantone = null;
                $request->subtype = null;
                break;
            default:
        }
        // Si es un asistente, validacion extra y obtener el ejecutivo, y si no
        // El ejecutivo es el creador
        $seller_id = '';
        $seller_name = '';
        if ($userCreator->hasRole('sales_assistant')) {
            request()->validate([
                'executive' => 'required',
            ]);
            $seller = User::find($request->executive);
            $seller_id = $seller->id;
            $seller_name = $seller->name . ' ' . $seller->lastname;
        } else {
            $seller_id = $userCreator->id;
            $seller_name = $userCreator->name . ' ' . $userCreator->lastname;
        }
        // Registrar el ticket

        $ticket = Ticket::create([
            'creator_id' => $creator_id,
            'creator_name' =>  $creator_name,
            'seller_id' => $seller_id,
            'seller_name' =>  $seller_name,
            'designer_id' => null,
            'designer_name' => null,
            'priority_id' => 2,
            'type_id' => $request->type,
            'subtype_id' => $request->subtype != null ? $request->subtype : null,
            'status_id' => 1
        ]);
        // Creacion del estado
        $status = Status::find(1);
        $statusChange = $ticket->statusChangeTicket()->create([
            'status_id' => $status->id,
            'status' => $status->status
        ]);
        // Registrar la informacion del ticket
        if ($request->companies) {
            $request->companies = implode(',', $request->companies);
        }

        if ($request->samples) {
            $request->samples = implode(',', $request->samples);
        }

        $ticketInformation = $ticket->ticketInformation()->create([
            'technique_id' => $request->technique,
            'customer' => $request->customer,
            'description' => $request->description,
            'modifier_name' => $creator_name,
            'modifier_id' => $creator_id,
            'title' => $request->title,
            'logo' => $request->logo,
            'items' => $request->items,
            'product' => $request->product,
            'pantone' => $request->pantone,
            'position' => $request->position,
            'companies' => $request->companies,
            'measures' => $request->measures,
            'samples' => $request->samples,
            'link' => '',
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $statusChange->id,
            'type' => 'status'
        ]);

        // Regresar a la vista de inicio
        return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticketInformation = $ticket->ticketInformation()->orderByDesc('created_at')->get();
        $messages = $ticket->messagesTicket()->orderByDesc('created_at')->get();
        $statuses = Status::all();
        $statusTicket = $ticket->latestStatusChangeTicket->status;

        $ticketHistories = $ticket->historyTicket;
        $ticketDeliveries = $ticket->deliveryTicket;

        return view(
            'seller.tickets.show',
            compact('messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories', 'ticketDeliveries')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $types = Type::all();
        $subtypes = Subtype::all();
        $techniques = Technique::all();
        $ticketInformation = $ticket->latestTicketInformation;
        return view('seller.tickets.edit', compact('techniques', 'ticket', 'types', 'ticketInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Obtener el id y el nombre del vendedor o asistente que esta editando
        $userCreator = User::find(auth()->user()->id);
        $creator_id = $userCreator->id;
        $creator_name = $userCreator->name . ' ' . $userCreator->lastname;
        switch ($ticket->typeTicket->id) {
            case 1:
                request()->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'technique' => 'required',
                    'position' => 'required',
                    'pantone' => 'required',
                    'description' => ['required'],
                    'customer' => ['required', 'string', 'max:255'],
                ]);
                $request->logo = $request->logo == null ?  $ticket->latestTicketInformation->logo : $request->logo;
                $request->product = $request->product == null ? $ticket->latestTicketInformation->product : $request->product;
                $request->items = $request->items;
                $request->companies = null;
                break;
            case 2:
                request()->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'customer' => ['required', 'string', 'max:255'],
                    'companies' => 'required',
                    'description' => ['required'],
                ]);
                $request->logo = $request->logo == null ?  $ticket->latestTicketInformation->logo : $request->logo;
                $request->items = $request->items == null ?  $ticket->latestTicketInformation->items : $request->items;
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->items = $request->items;
                break;
            case 3:
                request()->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'description' => ['required'],
                ]);
                $request->items = $request->items == null ?  $ticket->latestTicketInformation->items : $request->items;
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->logo = null;
                $request->customer = null;
                $request->companies = null;
                $request->items = $request->items;
                break;
            case 4:
                request()->validate([
                    'title' => ['required', 'string', 'max:191'],
                    'customer' => ['required', 'string', 'max:191'],
                    'description' => ['required', 'string', 'max:60000'],
                    'items' => 'required',
                ]);
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->logo = null;
                $request->customer = null;
                $request->companies = null;
                $request->measures = null;
                $request->subtype = null;
                $request->samples = $request->samples == null ?  $ticket->latestTicketInformation->samples : $request->samples[0];
                break;
            case 5:
                request()->validate([
                    'title' => ['required', 'string', 'max:191'],
                    'companies' => ['required'],
                    'samples' => ['required'],
                    'description' => ['required', 'string', 'max:60000'],
                    'logo' => 'required',
                    'product' => 'required',
                    'customer' => ['required', 'string', 'max:191'],
                    'measures' => 'required'
                ]);
                $request->items = $request->items == null ?  $ticket->latestTicketInformation->items : $request->items;
                $request->technique = null;
                $request->position = null;
                $request->pantone = null;
                $request->subtype = null;
                break;
            default:
                break;
        }

        // Registrar la informacion del ticket
        if ($request->companies) {
            $request->companies = implode(',', $request->companies);
        }
        $ticketInformation = $ticket->ticketInformation()->create([
            'technique_id' => $request->technique,
            'customer' => $request->customer,
            'description' => $request->description,
            'modifier_name' => $creator_name,
            'modifier_id' => $creator_id,
            'title' => $request->title,
            'logo' => $request->logo,
            'items' => $request->items,
            'product' => $request->product,
            'items' => $request->items,
            'pantone' => $request->pantone,
            'position' => $request->position,
            'companies' => $request->companies,
            'samples' => $request->samples[0] ?? null,
        ]);
        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);
        $status = 0;

        if ($ticket->latestStatusChangeTicket->status_id == 7) {
            $status = 10;
        } else {
            $status = $ticket->latestStatusChangeTicket->status_id;
        }

        if ($status != $ticket->latestStatusChangeTicket->status_id) {
            $newStatus = Status::find($status);
            $status = $ticket->statusChangeTicket()->create([
                'status_id' => $newStatus->id,
                'status' => $newStatus->status,
            ]);
            $ticket->status_id = $newStatus->id;
            $ticket->save();
            $ticket->historyTicket()->create([
                'ticket_id' => $ticket->id,
                'reference_id' => $status->id,
                'type' => 'status'
            ]);
        }

        $receiver = User::find($ticket->designer_id);
        if ($receiver) {
            try {
                ///Si sirve la linea de abajo descomentarla
                $receiver->notify(new TicketUpdate($request->title, $ticket->designer_name, $ticket->creator_name, $ticket->id));

                $receiver->notify(new TicketChangeNotification($ticket->id, $ticket->latestTicketInformation->title, $ticket->creator_name));
            } catch (Exception $th) {
                return 'Error al enviar la notificación';
                // Manejar la excepción de manera adecuada
            }
        }


        return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->action('TicketController@index');
    }

    public function uploadDeliveries(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . ' ' . str_replace(',', ' ', $imagen->getClientOriginalName());
        $imagen->move(public_path('storage/deliveries'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteDelivery(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/deliveries/' . $imagen)) {
                File::delete('storage/deliveries/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function checkWorkload($designerAssigments)
    {
        /*
           Revisar si hay cero diseñadores que pueden recibir este tipo de ticket
           En este caso asignarlo al gerente de diseño y que el lo reasigne si desea
        */
        if (count($designerAssigments) <= 0) {
            $designer = Role::find(5)->whatUsers;
            return $designer[0];
        }
        /*
            Si solo hay un diseñador que recibe ese ticket, asignar el ticket a ese diseñador
            Si no esta disponible por que falto o algo, asignarselo al gerente de diseño
        */
        if (count($designerAssigments) == 1) {
            $designerAssigment = User::find($designerAssigments[0]->designer_id);
            if ($designerAssigment->profile->availability) {
                return $designerAssigment;
            } else {
                $designer = Role::find(5)->whatUsers;
                return $designer[0];
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
                return $designer[0];
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
                return $newData[0]['designer'];
            } else {
                //TODO: Retornar a la persona que lleva mas tiempo si entregar un ticket
                $lastestTicket = [];
                foreach ($newData as $desNew) {
                    array_push($lastestTicket,  $desNew['designer']->assignedTickets()->whereIn('status_id', [2, 3, 5])->orderBy('updated_at', 'desc')->first());
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

                return User::find($lastestTicket[0]->designer_id);
            }
        }
    }

    //Comprimir archivos de ticket y descargarlos
    public function descargarArchivos(Ticket $ticket)
    {
        $public_dir = public_path('storage/zip');
        $zipFileName = $ticket->latestTicketInformation->title . '.zip';
        $zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            if ($ticket->latestTicketInformation->product) {
                foreach (explode(',', $ticket->latestTicketInformation->product) as $product) {
                    $zip->addFile(public_path('storage/products/' . $product), Str::substr($product, 11));
                }
            }
            if ($ticket->latestTicketInformation->logo) {
                foreach (explode(',', $ticket->latestTicketInformation->logo) as $logos) {
                    $zip->addFile(public_path('storage/logos/' . $logos), Str::substr($logos, 11));
                }
            }
            if ($ticket->latestTicketInformation->items) {
                foreach (explode(',', $ticket->latestTicketInformation->items) as $item) {
                    $zip->addFile(public_path('storage/items/' . $item), Str::substr($item, 11));
                }
            }
            $zip->close();
        }

        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath = $public_dir . '/' . $zipFileName;
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zipFileName, $headers);
        }
    }

    public function viewFile($file, $folder)
    {
        $path = '/storage/' . $folder . '/' . $file;
        $data = explode('.', $file);
        $extension = strtolower($data[count($data) - 1]);
        switch ($extension) {
            case 'pdf':
                return redirect(url($path));
                // return redirect(url($path));
                break;
            case 'png':
                return redirect(url($path));
                // return redirect(url($path));
                break;
            case 'jpg':
                return redirect(url($path));
                // return redirect(url($path));
                break;
            case 'jpeg':
                return redirect(url($path));
                // return redirect(url($path));
                break;
            case 'mp4':
                return redirect(url($path));
                // return redirect(url($path));
                break;
            case 'mp3':
                return redirect(url($path));
                // return redirect(url($path));
                break;
            case 'ai':
                $newName = '';
                unset($data[count($data) - 1]);
                foreach ($data as $part) {
                    $newName = $newName . $part . '.';
                }
                $newPath = $newName . 'ARCHIVO_AI';
                if (Storage::exists('public/tempDeliveries/' . $newPath)) {
                    Storage::delete('public/tempDeliveries/' . $newPath);
                }
                Storage::copy('public/' . $folder . '/' . $file, 'public/tempDeliveries/' . $newPath);
                return redirect(url('storage/tempDeliveries/' . $newPath));
                break;
            default:
                return view('administrador.tickets.dontShow', compact('extension', 'file'));
                break;
        }
        return view('administrador.tickets.dontShow', compact('extension', 'file'));
    }
}
