<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Component\PurchaseCard;
use Api\Component\RegisterCard;
use Api\Component\CheckSubscriptionCard;
use Api\Mock\MockResultCard;
use Api\Models\Applications;
use Api\Models\Devices;
use Api\Models\Subscriptions;
use Api\Traits\CryptoTrait;
use Api\Traits\ResponseTrait;
use Phalcon\Exception as HttpException;

use function json_decode;
use function json_encode;

class ApiController extends AbstractController
{
    use ResponseTrait;
    use CryptoTrait;

    public function register()
    {
        try {
            $postData = $this->request->getJsonRawBody();

            $card = new RegisterCard([
                'uid'      => $this->clean($postData->uid),
                'app_id'   => $this->clean($postData->app_id),
                'language' => $this->clean($postData->language),
                'os'       => $this->clean($postData->os),
            ]);

            if (true === $this->get_token_cache($card)) {
                return $this->response
                    ->setPayloadSuccess(['data' => ['token' => $this->session->get('token')]])
                    ->setStatusCode($this->response::ACCEPTED);
            }

            $app = Applications::findFirst(
                [
                    'conditions' => 'app_id = :app_id:',
                    'bind'       => [
                        'app_id' => $card->getAppId()
                    ],
                ]
            );

            if (! isset($app) || empty($app)) {
                throw new HttpException("Not Found", $this->response::NOT_FOUND);
            }

            $device = Devices::findFirst(
                [
                    'conditions' => 'uid = :uid: AND app_id = :app_id:',
                    'bind'       => [
                        'uid'    => $card->getUid(),
                        'app_id' => $app->app_id,
                    ],
                ]
            );

            if (! isset($device) || empty($device)) {
                $device = new Devices();
                $device->uid = $card->getUid();
                $device->app_id = $app->app_id;
                $device->language = $card->getLanguage();
                $device->os = $card->getOs();
                $device->token = $card->getToken();

                $result = $device->save();

                if (false === $result) {
                    $messages = $device->getMessages();
                    return $this->response
                        ->setPayloadErrors($messages)
                        ->setStatusCode($this->response::BAD_REQUEST);
                }
            }

            $this->set_token_cache($card);

            return $this->response
                ->setPayloadSuccess(['data' => ['token' => $device->token]])
                ->setStatusCode($this->response::CREATED);
        } catch (HttpException $ex) {
            $this->halt(
                $this->application,
                $ex->getCode(),
                $ex->getMessage()
            );
        }
    }

    public function purchase()
    {
        try {
            $token = $this->request->getBearerTokenFromHeader();

            if (! isset($token) || empty($token)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $postData = $this->request->getJsonRawBody();

            $card = new PurchaseCard([
                'receipt' => $this->clean($postData->receipt),
            ]);

            $cache_id = 'purch_'.$token.$card->getReceipt();

            $session = $this->session->get($cache_id);

            if (isset($session) && ! empty($session)) {
                $cache_result = json_decode($session, true, 512,JSON_THROW_ON_ERROR);
            }

            if (! isset($cache_result) || empty($cache_result)) {
                $cache = $this->cache->get($cache_id);
                if (isset($cache) && ! empty($cache)) {
                    $this->session->set($cache_id, $cache);
                    $cache_result = json_decode($session, true, 512,JSON_THROW_ON_ERROR);
                }
            }

            if (isset($cache_result) && ! empty($cache_result)) {
                return $this->response
                    ->setPayloadSuccess(['data' => new MockResultCard($cache_result)])
                    ->setStatusCode($this->response::OK);
            }

            $device = Devices::findFirst([
                'conditions' => 'token = :token:',
                'bind'       => [
                    'token' => $token
                ]
            ]);

            if (empty($device->token) || empty($device->app_id)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $app = Applications::findFirst(
                [
                    'conditions' => 'app_id = :app_id:',
                    'bind'       => [
                        'app_id' => $device->app_id
                    ],
                ]
            );

            if (! isset($app) || empty($app)) {
                throw new HttpException("Not Found", $this->response::NOT_FOUND);
            }

            $password = $this->decrypt($app->password);

            $mock = $this->mock
                ->setPlatform($this->mock::IOS)
                ->setUsername($app->username)
                ->setPassword($password)
                ->setPost(["receipt" => $card->getReceipt()])
                ->handle()
            ;

            $result = $mock->getResult();

            $subscriptions = new Subscriptions();

            $subscriptions->device_id = $device->id;
            $subscriptions->receipt = $result->getReceipt();
            $subscriptions->status = $result->getStatus();
            $subscriptions->expire_date = $result->getExpireDate();

            if (false === $subscriptions->save()) {
                $messages = $subscriptions->getMessages();
                foreach ($messages as $message) {
                    $this->logger->error($message);
                }
            }

            $device->status = $result->getStatus();
            $device->expire_date = $result->getExpireDate();

            if (false === $device->update()) {
                $messages = $device->getMessages();
                foreach ($messages as $message) {
                    $this->logger->error($message);
                }
            }

            if(true === $result->getStatus()) {
                $cache_id = 'purch_'.$token.$result->getReceipt();
                $this->session->set($cache_id, json_encode($result, JSON_THROW_ON_ERROR));
                $this->cache->set($cache_id, json_encode($result, JSON_THROW_ON_ERROR));
            }

            return $this->response
                ->setPayloadSuccess(['data' => $result])
                ->setStatusCode($this->response::OK);
        } catch (HttpException $ex) {
            $this->halt(
                $this->application,
                $ex->getCode(),
                $ex->getMessage()
            );
        }
    }

    public function check_subscription()
    {
        try {
            $token = $this->request->getBearerTokenFromHeader();

            if (! isset($token) || empty($token)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $device = Devices::findFirst([
                'conditions' => 'token = :token:',
                'bind'       => [
                    'token' => $token
                ]
            ]);

            if (empty($device->token) || empty($device->app_id)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $result = new CheckSubscriptionCard([
                'status'      => $device->status,
                'expire_date' => $device->expire_date
            ]);

            return $this->response
                ->setPayloadSuccess(['data' => $result])
                ->setStatusCode($this->response::OK);
        } catch (HttpException $ex) {
            $this->halt(
                $this->application,
                $ex->getCode(),
                $ex->getMessage()
            );
        }
    }
}
