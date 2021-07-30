<?php

namespace App\Console\Commands;

use App\Jobs\SubscriptionCard;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expired Subscription Send to Queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = new DateTime("now", new DateTimeZone("-6"));
        $today = $date->format('Y-m-d H:i:s');

        $appCredentials = DB::select('select * from app_credentials');

        $credentials = [];
        if($appCredentials) {
            foreach ($appCredentials as $credential) {
                $credentials[$credential->aid] = [
                    'aid' => $credential->aid,
                    'username' => $credential->username,
                    'password' => $credential->password
                ];
            }
        }

        $result = DB::select(
            'select * from subscriptions where `status` = 1 and `event` <> :event and expire_date < :today',
            ['event' => 'canceled', 'today' => $today]
        );

        if($result) {
            foreach ($result as $item) {

                $credential = true === isset($credentials[$item->aid]) ? $credentials[$item->aid] : false;

                if (! isset($credential) || empty($credential)) {
                    Log::error("App credential not found. App AID: {$item->aid}");
                    continue;
                }

                $card = (new SubscriptionCard())
                    ->setSid($item->sid)
                    ->setDaid($item->daid)
                    ->setReceipt($item->receipt)
                    ->setExpireDate($item->expire_date)
                    ->setEvent($item->event)
                    ->setUsername($credential['username'])
                    ->setPassword($credential['password'])
                    ;

                \App\Jobs\CheckSubscriptions::dispatch($card);
            }
        }

        return 0;
    }
}
