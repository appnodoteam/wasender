<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SendDocumentLinkRequest;
use App\Http\Requests\V1\SendDocumentRequest;
use App\Http\Requests\V1\SendTemplateRequest;
use App\Http\Requests\V1\SendTextRequest;
use App\Jobs\SendMessageDocumentJob;
use App\Jobs\SendMessageDocumentLinkJob;
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
        $path = $request->file('document')->store('documents');
        $url = asset($path);
        $filename = $request->file('document')->getClientOriginalName();
        $caption = $request->caption??$filename;

        SendMessageDocumentLinkJob::dispatch($request->number, $request->destination, $url, $caption, $filename);
    }

    public function sendDocumentLink(SendDocumentLinkRequest $request)
    {
        SendMessageDocumentLinkJob::dispatch($request->number, $request->destination, $request->link, $request->caption, $request->filename);
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
}
