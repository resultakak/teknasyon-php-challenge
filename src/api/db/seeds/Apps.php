<?php

use Phinx\Seed\AbstractSeed;
use Api\Traits\CryptoTrait;

class Apps extends AbstractSeed
{
    use CryptoTrait;

    public function run()
    {
        $password = base64_encode($this->encrypt(getenv('TEST_PASSWORD')));

        $data = [
            [
                'id'       => 1,
                'app_id'   => md5('App 1'),
                'username' => 'app_one',
                'password' => $password,
                'name'     => 'App 1',
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'id'       => 2,
                'app_id'   => md5('App 2'),
                'username' => 'app_two',
                'password' => $password,
                'name'     => 'App 2',
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'id'       => 3,
                'app_id'   => md5('App 3'),
                'username' => 'app_three',
                'password' => $password,
                'name'     => 'App 3',
                'created'  => date('Y-m-d H:i:s')
            ]
        ];

        $this->table('apps')->insert($data)->saveData();
    }
}
