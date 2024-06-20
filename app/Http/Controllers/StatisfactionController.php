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

        $respuesta1 = $request->input('respuesta_1');
        $comentario1 = $request->input('comentario_1');
        $ticket = $request->input('ticket_id');

        $respuesta1 = json_decode('"' . $respuesta1 . '"');
        $partes = explode(':', $respuesta1);
        $pregunta1 = trim($partes[0]);
        $respuesta1 = trim($partes[1]);
        /*     $respuesta1 = json_decode('"' . $respuesta2 . '"');
        $partes = explode(':', $respuesta2);
        $pregunta2 = trim($partes[0]);
        $respuesta_2 = trim($partes[1]); */

        $preguntas_respuestas = [
            ['pregunta' => $pregunta1, 'respuesta' => $respuesta1],
            /*     ['pregunta' => $pregunta2, 'respuesta' => $respuesta_2], */
        ];

        // Obtener el ticket
        $newticket = Ticket::where('id', $ticket)->first();

        // Guardar cada pregunta y su respuesta correspondiente
        foreach ($preguntas_respuestas as $item) {
            $satisfaction = SatisfactionModel::create([
                'designer' => $newticket->designer_name,
                'seller' => $newticket->creator_name,
                'ticket_id' => $ticket,
                'question' => $item['pregunta'],
                'answer' => $item['respuesta'],
                'comment' => $comentario1 ?? null,
            ]);
        }
        // Responder con un mensaje de éxito
        return Redirect::back()->with('success', 'Respuestas guardadas exitosamente.');
    }
}
