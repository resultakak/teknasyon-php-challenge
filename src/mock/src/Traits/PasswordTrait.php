<?php

declare(strict_types=1);

namespace App\Traits;

trait PasswordTrait
{
    protected function generate($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    protected function verify($password, $hashed_password)
    {
        if(password_verify($password, $hashed_password)) {
            return true;
        }
        return false;
    }
}
