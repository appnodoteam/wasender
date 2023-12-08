<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendOTPRequest;
use App\Http\Requests\V1\SendDocumentLinkRequest;
use App\Http\Requests\V1\SendDocumentRequest;
use App\Http\Requests\V1\SendTemplateRequest;
use App\Http\Requests\V1\SendTextRequest;
use App\Jobs\SendMessageDocumentJob;
use App\Jobs\SendMessageDocumentLinkJob;
use App\Jobs\SendMessageOTPJob;
use App\Jobs\SendMessageTemplateJob;
use App\Jobs\SendMessageTextJob;
use Illuminate\Http\Request;

class SendMessagesController extends Controller
{
    public function sendText(SendTextRequest $request)
    {
        SendMessageTextJob::dispatch($request->number, $request->destination, $request->message);

        return response()->json([
            'message' => 'Message added to queue'
        ]);
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
        $file = $request->file('document');
        $file->storeAs('public/documents', $file->getClientOriginalName());
        $public_url = asset('storage/documents/'.$file->getClientOriginalName());

        SendMessageDocumentLinkJob::dispatch(
            $request->number,
            $request->destination,
            $public_url,
            $request->caption ?? $file->getClientOriginalName(),
            $file->getClientOriginalName()
        );
        return response()->json([
            'message' => 'Message added to queue'
        ]);
    }

    public function sendDocumentLink(SendDocumentLinkRequest $request)
    {
        SendMessageDocumentLinkJob::dispatch($request->number, $request->destination, $request->link, $request->caption, $request->filename);
        return response()->json([
            'message' => 'Message added to queue'
        ]);
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
        SendMessageTemplateJob::dispatch($request->number, $request->destination, $request->template, $request->language, $request->params);
        return response()->json([
            'message' => 'Message added to queue'
        ]);
    }

    public function sendOTP(SendOTPRequest $request)
    {
        SendMessageOTPJob::dispatch($request->number, $request->destination, $request->template, $request->language, $request->otp);
        return response()->json([
            'message' => 'Message added to queue'
        ]);
    }
}
