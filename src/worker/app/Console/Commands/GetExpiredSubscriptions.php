<?php

namespace App\Console\Commands;

use App\Jobs\CheckSubscriptions;
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
            $password = getenv('TEST_PASSWORD');
            foreach ($appCredentials as $credential) {
                $credentials[$credential->aid] = [
                    'aid' => $credential->aid,
                    'username' => $credential->username,
                    'password' => $password, //$credential->password,
                    'platform' => $credential->platform,
                ];
            }
        }

        $result = DB::select(
            'select * from subscriptions where `status` = 1 and `event` <> :event and expire_date < :today',
            ['event' => 'canceled', 'today' => $today]
        );

        if(true !== is_array($result) || 0 === count($result)) {
            return 0;
        }

        if($result) {
            foreach ($result as $item) {
                try
                {
                    $credential = true === isset($credentials[$item->aid]) ? $credentials[$item->aid] : false;

                    if (! isset($credential) || empty($credential)) {
                        throw new \Exception("App credential not found. aid: {$item->aid} - sid: {$item->sid}");
                    }

                    $card = (new SubscriptionCard())
                        ->setSid($item->sid)
                        ->setDaid($item->daid)
                        ->setReceipt($item->receipt)
                        ->setExpireDate($item->expire_date)
                        ->setEvent($item->event)
                        ->setUsername($credential['username'])
                        ->setPassword($credential['password'])
                        ->setPlatform($credential['platform']);

                    CheckSubscriptions::dispatch($card);
                } catch (\Exception $ex) {
                    Log::error($ex->getMessage());
                }
            }
        }

        return 0;
    }
}
