<?php

use Phinx\Seed\AbstractSeed;

class Device extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'uid'      => sha1($faker->userName),
                'app_id'   => sha1($faker->email),
                'language' => 'en',
                'os'       => $i % 2 == 0 ? 'iOS' : 'Android',
                'created'  => date('Y-m-d H:i:s')
            ];
        }

        $this->table('devices')->insert($data)->saveData();
    }
}
