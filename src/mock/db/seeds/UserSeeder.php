<?php

use Phinx\Seed\AbstractSeed;
use App\Traits\PasswordTrait;

class UserSeeder extends AbstractSeed
{
    use PasswordTrait;

    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];

        $password = $this->generate(getenv('TEST_PASSWORD'));

        $data[] = [
            'name'     => 'app_one',
            'password' => $password,
            'created'  => date('Y-m-d H:i:s'),
        ];

        $data[] = [
            'name'     => 'app_two',
            'password' => $password,
            'created'  => date('Y-m-d H:i:s'),
        ];

        $data[] = [
            'name'     => 'app_three',
            'password' => $password,
            'created'  => date('Y-m-d H:i:s'),
        ];

        for ($i = 0; $i < 97; $i++) {
            $data[] = [
                'name'     => $faker->userName,
                'password' => $password,
                'created'  => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('credentials')->insert($data)->saveData();
    }
}
