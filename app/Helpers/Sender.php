<?php

namespace App\Helpers;

use App\Models\V1\Number;
use Illuminate\Support\Facades\Log;

class Sender
{
    public $client;
    // constructor
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    static function sendText($number, $text, $version = "17.0", $origin, $preview = false){
        $searchNumber = Number::where('number', $origin)->first();
        $url = 'https://graph.facebook.com/'.$version.'/'.$searchNumber->number_id.'/messages';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$searchNumber->permanent_token?? $searchNumber->temporary_token,
        ];
        $body = '{
          "messaging_product": "whatsapp",
          "to": "50231784567",
          "type": "text",
          "text": {
            "preview": "'.$preview.'",
            "body": "'.$text.'"
          }
        }';
        $sender = new self();
        $response = $sender->useApi('POST', $url, $body, $headers);
        return $response->getBody()->getContents();
    }

    private function useApi($method, $url, $data, $headers)
    {
        try{
            $response = $this->client->request($method, $url, [
                'headers' => $headers,
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }

}
