<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Models\Users;

trait QueryTrait
{

    protected function findUserByUsername($username)
    {
        $users = Users::findFirst([
            'name = ?0',
            'bind' => [$username],
        ]);

        return isset($users->name) ? $users : false;
    }

}
