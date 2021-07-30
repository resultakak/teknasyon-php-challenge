<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int $tries
     */
    public $tries = 3;

    /**
     * @var int $maxExceptions
     */
    public $maxExceptions = 3;

    /**
     * @var SubscriptionCard $card
     */
    public $card;

    /**
     * @param SubscriptionCard $card
     */
    public function __construct(SubscriptionCard $card)
    {
        $this->card = $card;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $password = \getenv('TEST_PASSWORD');

        $authorization = 'Basic '.\base64_encode($this->card->getUsername().':'.$password);

        $response = Http::withHeaders(['Authorization' => $authorization])
            ->acceptJson()
            ->post('https://t-mock.resul.me/api/ios/receipt/verify', ['receipt' => $this->card->getReceipt()])
            ->json();

        if ( true === isset($response['data'])) {
            Log::info($response['data']);
        }
    }
}
