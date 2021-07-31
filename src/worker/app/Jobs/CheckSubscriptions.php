<?php

namespace App\Jobs;

use _PHPStan_8f2e45ccf\Nette\Neon\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
    protected SubscriptionCard $card;

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
        $authorization = 'Basic '.base64_encode($this->card->getUsername().':'.$this->card->getPassword());

        $url = str_replace("{platform}", $this->card->getPlatform(), env('MOCK_API_URL'));

        $response = Http::withHeaders(['Authorization' => $authorization])
            ->acceptJson()
            ->post($url, ['receipt' => $this->card->getReceipt()])
            ->json();

        if (true === isset($response['data'])) {
            $item = $response['data'];

            if ($item['status'] === true) {
                $item['event'] = 'renewed';
            } else {
                $item['event'] = 'canceled';
                $item['expire_date'] = date('Y-m-d H:i:', 0);
            }

            $affected = DB::table('subscriptions')
                ->where('sid', $this->card->getSid())
                ->update(
                    [
                        'status' => $item['status'],
                        'expire_date' => $item['expire_date'],
                        'event' => $item['event']
                    ]
                );

            if (false === $affected) {
                throw new Exception("Failed: ".$item['receipt']);
            }
        }
    }
}
