<?php

namespace App\Helpers;

use App\Jobs\MessageResponseJob;
use App\Models\V1\Message;
use App\Models\V1\Number;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Sender
{

    static function sendText(Number $number, $destination, $text) : void
    {
        $url = 'https://graph.facebook.com/'.$number->api_version.'/'.$number->number_id.'/messages';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$number->token,
        ];
        $body = '{
          "messaging_product": "whatsapp",
          "to": "'.$destination.'",
          "type": "text",
          "text": {
            "preview_url": true,
            "body": "'.$text.'"
          }
        }';
        $sender = new self();
        $sender->useApi('POST', $url, $body, $headers, $text,$number);
    }

    static function sendTemplate(Number $number, $destination, $template, $lang, $components = []) : void
    {
        $url = 'https://graph.facebook.com/'.$number->api_version.'/'.$number->number_id.'/messages';
        $comps = $components ? ',"components": '.json_encode($components) : '';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$number->token,
        ];
        $body = '{
          "messaging_product": "whatsapp",
          "to": "'.$destination.'",
          "type": "template",
          "template": {
            "name": "'.$template.'",
            "language": {
              "code": "'.$lang.'"
            }'.$comps.'
          }
        }';
        $sender = new self();
        $sender->useApi('POST', $url, $body, $headers, "template: ".$template, $number);
    }

    public static function sendDocumentLink(Number $number, $destination, $link, $caption, $filename) : void
    {
        Log::warning("sendDocumentLink", [
            'number' => $number->id,
            'destination' => $destination,
            'link' => $link,
            'caption' => $caption,
            'filename' => $filename,
        ]);
        $url = 'https://graph.facebook.com/'.$number->api_version.'/'.$number->number_id.'/messages';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$number->token,
        ];
        $body = '{
          "messaging_product": "whatsapp",
          "to": "'.$destination.'",
          "type": "document",
          "document": {
            "link": "'.$link.'",
            "caption": "'.$caption.'",
            "filename": "'.$filename.'"
          }
        }';
        $sender = new self();
        $sender->useApi('POST', $url, $body, $headers, "document: ".$link, $number);
    }

    private function useApi($method, $url, $data, $headers, $text,Number $number) : void
    {
        try{
            $client = new \GuzzleHttp\Client();
            $request = new Request($method, $url, $headers, $data);
            $response = $client->sendAsync($request)->wait();
            $res = $response->getBody()->getContents();

            $xdata = json_decode($data, true);

            $m = [
                'message' => $text??"--empty--",
                'destination' => $xdata['to'],
                'number_id' => $number->id,
                'status' => $response->getStatusCode() == 200 ? 'sent' : 'failed',
                'response' => json_decode($res, true),
            ];

            if($number->save_messages) {
                MessageResponseJob::dispatch($m);
            }


        } catch (\Exception $e) {
            Log::error($e);

        }

    }

}
