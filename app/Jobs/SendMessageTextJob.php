<?php

namespace App\Jobs;

use App\Helpers\Sender;
use App\Http\Requests\StoreNumberRequest;
use App\Models\V1\Number;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $number;
    protected $destination;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct(Number $number, string $destination, string $message)
    {
        $this->number = $number;
        $this->destination = $destination;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sender = new Sender();
        $sender->sendText($this->number, $this->destination, $this->message);
    }
}
