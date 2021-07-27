<?php

declare(strict_types=1);

namespace App\Traits;

trait PasswordTrait
{

    /**
     * @param string $password
     * @return string
     */
    protected function hashing(string $password): string
    {
        return sha1(getenv('APP_KEY').$password);
    }

    /**
     * @param string $password
     * @return string
     */
    protected function generate(string $password): string
    {
        return password_hash($this->hashing($password), PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @param string $hashed_password
     * @return bool
     */
    protected function verify(string $password, string $hashed_password): bool
    {
        if(password_verify($this->hashing($password), $hashed_password)) {
            return true;
        }

        return false;
    }
}
