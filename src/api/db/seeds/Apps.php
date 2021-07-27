<?php

use Phinx\Seed\AbstractSeed;

class Apps extends AbstractSeed
{

    public function run()
    {
        $data = [
            [
                'id'      => 1,
                'app_id'  => md5('App 1'),
                'name'    => 'App 1',
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'id'      => 2,
                'app_id'  => md5('App 2'),
                'name'    => 'App 2',
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'id'      => 3,
                'app_id'  => md5('App 3'),
                'name'    => 'App 3',
                'created' => date('Y-m-d H:i:s')
            ]
        ];

        $this->table('apps')->insert($data)->saveData();
    }
}
