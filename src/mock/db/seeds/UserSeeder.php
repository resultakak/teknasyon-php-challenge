<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{

    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'name'     => $faker->userName,
                'password' => sha1($faker->password),
                'created'  => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('credentials')->insert($data)->saveData();
    }
}
