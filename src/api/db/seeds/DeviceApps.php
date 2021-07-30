<?php

use Phinx\Seed\AbstractSeed;

class DeviceApps extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Uuid($faker));

        $apps = [
            1 => 'a96d6de3ed11b646545d74908788d54e',
            2 => '0cf0cf9bc1d6f20e66f465201210a883',
            3 => 'bb2693916fa7f873fa45d9625073e916',
        ];

        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $uid = $i === 1 ? '566dceed-f87a-3191-864e-9ab1d519300d' : $faker->uuid;
            $app_id = rand(1,3);
            $app_id = $apps[$app_id];

            $token = [
                'uid'    => sha1(md5(strtolower(trim($uid)))),
                'app_id' => sha1(md5(strtolower(trim($app_id)))),
                'key'    => sha1(getenv('APP_KEY'))
            ];

            $data[] = [
                'did'      => random_int(1,100),
                'aid'      => random_int(1,100),
                'token'    => md5(sha1(json_encode($token))),
                'created'  => date('Y-m-d H:i:s')
            ];
        }

        $this->table('device_apps')->insert($data)->saveData();
    }
}