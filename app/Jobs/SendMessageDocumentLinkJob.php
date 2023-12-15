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

class SendMessageDocumentLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $number;
    protected $destination;
    protected $link;
    protected $caption;
    protected $filename;

    /**
     * Create a new job instance.
     */
    public function __construct(Number $number, $destination, $link, $caption, $filename)
    {
        $this->number = $number;
        $this->destination = $destination;
        $this->link = $link;
        $this->caption = $caption;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sender = new Sender();
        $sender->sendDocumentLink($this->number, $this->destination, $this->link, $this->caption, $this->filename);
    }
}
