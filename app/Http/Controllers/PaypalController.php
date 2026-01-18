<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    //
    public function index()
    {
        $messages = Message::latest()->get(); // Trae los más recientes primero
        return view('message', compact('messages'));
    }

    public function handleRefound(Request $req)
    {
        $payload = $req->all();
        $eventType = $payload['event_type'] ?? null;

        // 1. (Opcional pero recomendado) Verificar la firma del webhook aquí 
        // para asegurar que viene de PayPal.

        // 2. Procesar según el tipo de evento
        switch ($eventType) {
            case 'PAYMENT.CAPTURE.REFUNDED':
            case 'PAYMENT.CAPTURE.REVERSED':
                $this->createMessage($payload, 'Reembolso o Reversión detectada');
                // Aquí podrías actualizar el estado de tu factura/colegiatura
                break;

            case 'CUSTOMER.DISPUTE.CREATED':
                $this->createMessage($payload, 'Disputa abierta por el cliente');
                break;

            default:
                Log::info("Evento de PayPal no procesado: " . $eventType);
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function createMessage($data, $content)
    {
        Message::create([
            'event_id'   => $data['id'],
            'content' => $content,
        ]);
    }

    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'event_id' => 'required|string',
            'content' => 'required|string',
        ]);

        // Creación del registro
        Message::create([
            'event_id' => $request->event_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Mensaje creado correctamente');
    }
}
