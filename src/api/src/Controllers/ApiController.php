<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Component\PurchaseCard;
use Api\Component\RegisterCard;
use Api\Models\Devices;
use Api\Traits\ResponseTrait;
use Api\Exception\HttpException;

class ApiController extends AbstractController
{
    use ResponseTrait;

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

            $cache_id = 'token_'.md5($card->getToken());

            $token = $this->cache->get($cache_id);

            if (empty($token)) {
                $device = Devices::findFirst(
                    [
                        'conditions' => 'uid = :uid: AND app_id = :app_id:',
                        'bind'       => [
                            'uid'    => $card->getUid(),
                            'app_id' => $card->getAppId(),
                        ],
                    ]
                );

                if (empty($device)) {
                    $device = new Devices();
                    $device->uid = $card->getUid();
                    $device->app_id = $card->getAppId();
                    $device->language = $card->getLanguage();
                    $device->os = $card->getOs();

                    $result = $device->save();

                    if (false === $result) {
                        $messages = $device->getMessages();

                        return $this->response
                            ->setPayloadErrors($messages)
                            ->setStatusCode($this->response::BAD_REQUEST);

                    }
                }

                $token = $card->getToken();
                $this->cache->set($cache_id, $token);
            }

            return $this->response
                ->setPayloadSuccess(['data' => ['token' => $token]])
                ->setStatusCode($this->response::OK);
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

            return $this->response
                ->setPayloadSuccess(['data' => $card])
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

            return $this->response
                ->setPayloadSuccess(['data' => $token])
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
