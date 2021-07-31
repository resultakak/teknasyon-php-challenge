<?php

use Phinx\Seed\AbstractSeed;
use Api\Traits\CryptoTrait;

class Apps extends AbstractSeed
{
    use CryptoTrait;

    public function run()
    {
        $data = [
            [
                'aid'       => 1,
                'app_id'   => md5('App 1'),
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'aid'       => 2,
                'app_id'   => md5('App 2'),
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'aid'       => 3,
                'app_id'   => md5('App 3'),
                'created'  => date('Y-m-d H:i:s')
            ]
        ];

        $this->table('apps')->insert($data)->saveData();
    }
}
