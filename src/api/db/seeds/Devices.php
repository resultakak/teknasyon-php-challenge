<?php

use Phinx\Seed\AbstractSeed;

class Devices extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Uuid($faker));

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $uid = $i === 1 ? '566dceed-f87a-3191-864e-9ab1d519300d' : $faker->uuid;
            $data[] = [
                'uid'      => $uid,
                'language' => 'en',
                'platform' => (0 === (random_int(1,12) % 2)) ? 'IOS' : 'ANDROID',
                'created'  => date('Y-m-d H:i:s')
            ];
        }

        $this->table('devices')->insert($data)->saveData();
    }
}
