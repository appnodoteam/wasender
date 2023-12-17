<?php

namespace App\Http\Controllers\V2\Api;

use App\Http\Controllers\Controller;
use App\Models\V1\Number;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function webhook(Request $request,$number)
    {
        try{
            $current_number = Number::findOrFail($number);
            $verify_token = $current_number->webhook_verify_token;
            $mode = $request->input('hub.mode');
            $token = $request->input('hub.verify_token');
            $challenge = $request->input('hub.challenge');

            // Verifica si se enviaron un modo (mode) y un token
            if ($mode && $token) {
                // Verifica que el modo y el token enviados sean correctos
                if ($mode === "subscribe" && $token === $verify_token) {
                    // Responde con 200 OK y el token de desafío desde la solicitud
                    echo "WEBHOOK_VERIFIED";
                    return response($challenge, 200);
                } else {
                    // Responde con '403 Forbidden' si los tokens de verificación no coinciden
                    return response(null, 403);
                }
            }
        } catch (\Exception $e){
            return response()->json([
                'message' => "no number found"
            ], 500);
        }
    }
}
