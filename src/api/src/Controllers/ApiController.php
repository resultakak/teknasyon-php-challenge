<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Component\PurchaseCard;
use Api\Component\RegisterCard;
use Api\Component\SubscriptionResultCard;
use Api\Http\Request;
use Api\Http\Response;
use Api\Mock\Mock;
use Api\Models\AppCredentials;
use Api\Models\Applications;
use Api\Models\DeviceApps;
use Api\Models\Devices;
use Api\Models\Subscriptions;
use Api\Traits\CryptoTrait;
use Api\Traits\ResponseTrait;
use Phalcon\Exception as HttpException;

/**
 * Class ApiController
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 *
 * @property Phalcon\Mvc\Micri $application;
 * @property Response          $response   ;
 * @property Request           $request    ;
 */
class ApiController extends AbstractController
{
    use ResponseTrait;
    use CryptoTrait;

    /**
     * @return Response|void
     */
    public function register()
    {
        try {
            $postData = $this->request->getJsonRawBody();

            $card = new RegisterCard(
                [
                    'uid'      => $this->clean($postData->uid),
                    'app_id'   => $this->clean($postData->app_id),
                    'language' => $this->clean($postData->language),
                    'platform' => $this->clean($postData->platform),
                ]
            );

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
                    ]
                ]
            );

            if (true === is_null($app)) {
                throw new HttpException("Application Not Found", $this->response::NOT_FOUND);
            }

            $device = Devices::findFirst(
                [
                    'conditions' => 'uid = :uid:',
                    'bind'       => [
                        'uid' => $card->getUid()
                    ],
                    'order'      => 'did desc',
                ]
            );

            if (true === is_null($device)) {
                $device = new Devices();
                $device->uid = $card->getUid();
                $device->language = $card->getLanguage();
                $device->platform = $card->getPlatform();

                $result = $device->save();

                if (false === $result) {
                    $messages = $device->getMessages();
                    return $this->response
                        ->setPayloadErrors($messages)
                        ->setStatusCode($this->response::BAD_REQUEST);
                }
            }

            $deviceApp = DeviceApps::findFirst(
                [
                    'conditions' => 'did = :did: AND aid = :aid:',
                    'bind'       => [
                        'did' => $device->did,
                        'aid' => $app->aid
                    ],
                    'order'      => 'daid desc',
                ]
            );

            if (true === is_null($deviceApp)) {
                $deviceApp = new DeviceApps();
                $deviceApp->daid = null;
                $deviceApp->did = (int) $device->did;
                $deviceApp->aid = (int) $app->aid;
                $deviceApp->token = $card->getToken();
                $deviceApp->created = null;

                $result = $deviceApp->save();

                if (false === $result) {
                    $messages = $deviceApp->getMessages();
                    return $this->response
                        ->setPayloadErrors($messages)
                        ->setStatusCode($this->response::BAD_REQUEST);
                }
            }

            $this->set_token_cache($card);

            return $this->response
                ->setPayloadSuccess(['data' => ['token' => $deviceApp->token]])
                ->setStatusCode($this->response::CREATED);
        } catch (HttpException $ex) {
            $this->halt(
                $this->application,
                $ex->getCode(),
                $ex->getMessage()
            );
        }
    }

    /**
     * @return Response|void
     */
    public function purchase()
    {
        try {
            $token = $this->request->getBearerTokenFromHeader();

            if (! is_string($token)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $postData = $this->request->getJsonRawBody();

            $card = new PurchaseCard(
                [
                    'receipt' => $this->clean($postData->receipt),
                ]
            );

            $cache_id = $this->cacheManager->cache_id([$token], "subs_");

            $cache = $this->cacheManager->get($cache_id);

            if (false !== $cache) {
                if (true === isset($cache['receipt']) && $cache['receipt'] === $card->getReceipt()) {
                    return $this->response
                        ->setPayloadSuccess(['data' => $cache])
                        ->setStatusCode($this->response::OK);
                }
            }

            /** @var DeviceApps $deviceApp */
            $deviceApp = DeviceApps::findFirst(
                [
                    'conditions' => 'token = :token:',
                    'bind'       => [
                        'token' => $token
                    ]
                ]
            );

            if (true === is_null($deviceApp)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            /** @var AppCredentials $appCredential */
            $appCredential = AppCredentials::findFirst(
                [
                    'conditions' => 'aid = :aid:',
                    'bind'       => [
                        'aid' => $deviceApp->aid
                    ],
                ]
            );

            if (true === is_null($appCredential)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $password = $this->decrypt($appCredential->password);

            /** @var Mock $mock */
            $mock = $this->mock
                ->setPlatform($this->mock::IOS)
                ->setUsername($appCredential->username)
                ->setPassword($password)
                ->setPost(["receipt" => $card->getReceipt()])
                ->handle();

            $result = $mock->getResult();

            if (true === is_null($result)) {
                throw new HttpException("Not Implemented", $this->response::NOT_IMPLEMENTED);
            }

            /** @var Subscriptions $subscriptions */
            $subscriptions = Subscriptions::findFirst(
                [
                    'conditions' => 'daid = :daid:',
                    'bind'       => [
                        'daid' => $deviceApp->daid
                    ],
                    'order'      => 'sid desc'
                ]
            );

            if (true === is_null($subscriptions)) {
                $subscriptions = new Subscriptions();
                $subscriptions->sid = null;
                $subscriptions->daid = $deviceApp->daid;
                $subscriptions->did = $deviceApp->did;
                $subscriptions->aid = $deviceApp->aid;
                $subscriptions->receipt = $result->getReceipt();
                $subscriptions->status = $result->hasStatus();
                $subscriptions->expire_date = $result->getExpireDate();
                $subscriptions->event = 'canceled';
                $subscriptions->created = null;

                if (false === $subscriptions->save()) {
                    $messages = $subscriptions->getMessages();
                    foreach ($messages as $message) {
                        $this->logger->error($message);
                    }
                }
            } else {
                $subscriptions->receipt = $result->getReceipt();
                $subscriptions->status = $result->hasStatus();
                $subscriptions->expire_date = $result->getExpireDate();
                $subscriptions->event = 'canceled';

                if (false === $subscriptions->update()) {
                    $messages = $subscriptions->getMessages();
                    foreach ($messages as $message) {
                        $this->logger->error($message);
                    }
                }
            }

            $result = new SubscriptionResultCard(
                [
                    'receipt'     => $subscriptions->receipt,
                    'status'      => $subscriptions->status,
                    'status_text' => $subscriptions->event,
                    'expire_date' => $subscriptions->expire_date,
                ]
            );

            $this->cacheManager->set($cache_id, $result);

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

    /**
     * @return Response|void
     */
    public function check_subscription()
    {
        try {
            $token = $this->request->getBearerTokenFromHeader();

            if (! isset($token) || empty($token)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            $cache_id = $this->cacheManager->cache_id([$token], "subs_");

            $cache = $this->cacheManager->get($cache_id);

            if (false !== $cache) {
                return $this->response
                    ->setPayloadSuccess(['data' => $cache])
                    ->setStatusCode($this->response::OK);
            }

            /** @var DeviceApps $deviceApp */
            $deviceApp = DeviceApps::findFirst(
                [
                    'conditions' => 'token = :token:',
                    'bind'       => [
                        'token' => $token
                    ]
                ]
            );

            if (true === is_null($deviceApp)) {
                throw new HttpException("Unauthorized", $this->response::UNAUTHORIZED);
            }

            /** @var Subscriptions $deviceApp */
            $subscriptions = Subscriptions::findFirst(
                [
                    'conditions' => 'daid = :daid:',
                    'bind'       => [
                        'daid' => $deviceApp->daid
                    ],
                    'order'      => 'sid desc',
                ]
            );

            if (true === is_null($subscriptions)) {
                throw new HttpException("Not Found", $this->response::NOT_FOUND);
            }

            $result = new SubscriptionResultCard(
                [
                    'receipt'     => $subscriptions->receipt,
                    'status'      => $subscriptions->status,
                    'status_text' => $subscriptions->event,
                    'expire_date' => $subscriptions->expire_date,
                ]
            );

            $this->cacheManager->set($cache_id, $result);

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
