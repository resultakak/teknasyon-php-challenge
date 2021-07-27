<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Models\User;
use App\Traits\PasswordTrait;
use App\Traits\QueryTrait;
use App\Traits\ResponseTrait;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class AuthenticationMiddleware implements MiddlewareInterface
{
    use ResponseTrait;
    use PasswordTrait;
    use QueryTrait;

    public function call(Micro $mock)
    {
        /** @var Request $request */
        $request  = $mock->getService('request');
        /** @var Response $response */
        $response = $mock->getService('response');

        $userName = $request->getServer('PHP_AUTH_USER');
        $password = $request->getServer('PHP_AUTH_PW');

        if(true === isset($userName)) {
            /** @var User $user */
            $user = $this->findUserByUsername($userName);

            if(true === isset($password) && true === isset($user->password) && true === $this->verify($password, $user->password)) {
                return true;
            }
        }

        $this->halt(
            $mock,
            $response::UNAUTHORIZED,
            'Invalid Token'
        );
    }
}
