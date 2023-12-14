<?php

namespace App\Http\Controllers\V1\Api;

use App\Helpers\Direct;
use App\Helpers\Sender;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendOTPRequest;
use App\Http\Requests\V1\SendDocumentLinkRequest;
use App\Http\Requests\V1\SendDocumentRequest;
use App\Http\Requests\V1\SendTemplateRequest;
use App\Http\Requests\V1\SendTextRequest;
use App\Jobs\SendMessageDocumentLinkJob;
use App\Jobs\SendMessageOTPJob;
use App\Jobs\SendMessageTemplateJob;
use App\Jobs\SendMessageTextJob;
use App\Models\V1\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendMessagesController extends Controller
{
    public function sendText(SendTextRequest $request)
    {
        try{
            $user = $request->user();
            $direct = new Direct();
            $number = $user->numbers()->findOrFail($request->number);
            $rex = $direct->sendText($number, $request->destination, $request->message);
            if($rex == "sent"){
                return response()->json([
                    'message' => 'Message sent'
                ]);
            } else {
                return response()->json([
                    'message' => $rex
                ], 500);
            }
        } catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendImage(Request $request)
    {
        //
    }

    public function sendVideo(Request $request)
    {
        //
    }

    public function sendAudio(Request $request)
    {
        //
    }

    public function sendDocument(SendDocumentRequest $request)
    {
        $user = $request->user();
        try{
            $number = $user->numbers()->findOrFail($request->number);
            $file = $request->file('document');
            $file->storeAs('public/documents', $file->getClientOriginalName());
            $public_url = asset('storage/documents/'.$file->getClientOriginalName());
            $sender = new Direct();
            $res = $sender->sendDocumentLink(
                $number,
                $request->destination,
                $public_url,
                    $request->caption ?? $file->getClientOriginalName(),
                $file->getClientOriginalName()
            );
        } catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        if($res == "sent"){
            return response()->json([
                'message' => 'Message sent'
            ]);
        } else {
            return response()->json([
                'message' => $res
            ], 500);
        }

    }

    public function sendDocumentLink(SendDocumentLinkRequest $request)
    {
        $user = $request->user();
        try{
            $number = $user->numbers()->findOrFail($request->number);
            $sender = new Direct();
            $res = $sender->sendDocumentLink($number, $request->destination, $request->link, $request->caption, $request->filename);
        } catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        if($res == "sent"){
            return response()->json([
                'message' => 'Message sent'
            ]);
        } else {
            return response()->json([
                'message' => $res
            ], 500);
        }
    }

    public function sendLocation(Request $request)
    {
        //
    }

    public function sendContact(Request $request)
    {
        //
    }

    public function sendSticker(Request $request)
    {
        //
    }

    public function sendVoice(Request $request)
    {
        //
    }

    public function sendTemplate(SendTemplateRequest $request)
    {
        $user = $request->user();
        try{
            $number = $user->numbers()->findOrFail($request->number);
            $components = [];
            if ($request->params) {
                $paramsArray = [];
                foreach ($request->params as $key => $value) {
                    $paramsArray[] = [
                        'type' => 'text',
                        'text' => $value
                    ];
                }
                $components[] = [
                    'type' => "body",
                    'parameters' => $paramsArray
                ];

            }

            $direct = new Direct();

            $res = $direct->sendTemplate($number, $request->destination, $request->template, $request->language, $components);
        } catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        if($res == "sent"){
            return response()->json([
                'message' => 'Message sent'
            ]);
        } else {
            return response()->json([
                'message' => $res
            ], 500);
        }
    }

    public function sendOTP(SendOTPRequest $request)
    {
        $user = $request->user();
        $components = [
            [
                'type' => "body",
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $request->otp
                    ]
                ]
            ],
            [
                'type' => 'button',
                'sub_type' => 'url',
                'index' => '0',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $request->otp
                    ]
                ],
            ]
        ];

        try{
            $number = $user->numbers()->findOrFail($request->number);
            $direct = new Direct();
            $res = $direct->sendTemplate($number, $request->destination, $request->template, $request->language, $components);
        } catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        if($res == "sent"){
            return response()->json([
                'message' => 'Message sent'
            ]);
        } else {
            return response()->json([
                'message' => $res
            ], 500);
        }
    }
}
