<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Users;

trait QueryTrait
{
    /**
     * @param $username
     * @return object|false
     */
    protected function findUserByUsername($username)
    {
        if (! isset($username) || empty($username)) {
            return false;
        }

        /** @var Users $users */
        $users = Users::findFirst([
            'name = ?0',
            'bind' => [$username],
        ]);

        return $users ?? false;
    }
}
