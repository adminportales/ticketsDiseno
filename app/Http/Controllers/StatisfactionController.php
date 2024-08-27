<?php

namespace App\Http\Controllers;

use App\SatisfactionModel;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StatisfactionController extends Controller
{
    public function store(Request $request)
    {
        $respuesta = $request->respuesta_1;
        $comentario1 = $request->comentario_1;
        $ticket = $request->ticket_id;
        $pregunta = $request->pregunta;

        // Obtener el ticket
        $newticket = Ticket::where('id', $ticket)->first();

        // Guardar cada pregunta y su respuesta correspondiente
        $satisfaction = SatisfactionModel::create([
            'designer' => $newticket->designer_name,
            'seller' => $newticket->creator_name,
            'ticket_id' => $ticket,
            'question' => $pregunta,
            'answer' => $respuesta,
            'comment' => $comentario1 ?? null,
        ]);
        // Responder con un mensaje de éxito
        return response()->json(['message' => 'OK']);
    }
}
