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
use Illuminate\Support\Facades\Log;

class SendMessageTemplateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $number;
    protected $destination;
    protected $template;
    protected $lang = 'en_US';
    protected $params;

    /**
     * Create a new job instance.
     */
    public function __construct(Number $number, string $destination, string $template, string $lang = 'en_US', $params = [])
    {
        $this->number = $number;
        $this->destination = $destination;
        $this->template = $template;
        $this->lang = $lang;
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $components = [];
        if ($this->params) {
            $paramsArray = [];
            foreach ($this->params as $key => $value) {
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

        $sender = new Sender();
        $sender->sendTemplate($this->number, $this->destination, $this->template, $this->lang, $components);
    }
}
