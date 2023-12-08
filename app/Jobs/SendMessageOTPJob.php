<?php

namespace App\Jobs;

use App\Helpers\Sender;
use App\Models\V1\Number;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageOTPJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $number;
    protected $destination;
    protected $template;
    protected $lang = 'en_US';
    protected $otp;

    /**
     * Create a new job instance.
     */
    public function __construct(string $number, string $destination, string $template, string $lang = 'en_US', $otp = [])
    {
        $this->number = $number;
        $this->destination = $destination;
        $this->template = $template;
        $this->lang = $lang;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $components = [
            [
                'type' => "body",
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $this->otp
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
                        'text' => $this->otp
                    ]
                ],
            ]
        ];

        $sender = new Sender();
        $number = Number::find($this->number);
        $sender->sendTemplate($number, $this->destination, $this->template, $this->lang, $components);
    }
}
