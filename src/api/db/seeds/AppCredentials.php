<?php

use Api\Traits\CryptoTrait;
use Phinx\Seed\AbstractSeed;

class AppCredentials extends AbstractSeed
{
    use CryptoTrait;

    public function getDependencies()
    {
        return [
            'Apps'
        ];
    }

    public function run()
    {
        $password = $this->encrypt(getenv('TEST_PASSWORD'));

        $data = [
            [
                'acid'     => 1,
                'aid'      => 1,
                'username' => 'app_one',
                'password' => $password,
                'platform' => (0 === (random_int(1,12) % 2)) ? 'IOS' : 'ANDROID',
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'acid'     => 2,
                'aid'      => 2,
                'username' => 'app_two',
                'password' => $password,
                'platform' => (0 === (random_int(1,12) % 2)) ? 'IOS' : 'ANDROID',
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'acid'     => 3,
                'aid'      => 3,
                'username' => 'app_three',
                'password' => $password,
                'platform' => (0 === (random_int(1,12) % 2)) ? 'IOS' : 'ANDROID',
                'created'  => date('Y-m-d H:i:s')
            ]
        ];

        $this->table('app_credentials')->insert($data)->saveData();
    }
}
