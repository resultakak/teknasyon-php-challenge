<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Component\PurchaseCard;
use Api\Component\RegisterCard;
use Api\Http\Response;
use Api\Models\Devices;
use Api\Traits\ResponseTrait;
use Api\Exception\HttpException;

class ApiController extends AbstractController
{
    use ResponseTrait;

    public function register(): Response
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

                /*
                 * @TODO APP listesi oluşturulacak
                 */

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
            return $this->response
                ->setPayloadError($ex->getMessage())
                ->setStatusCode($this->response::OK);
        }
    }

    public function purchase(): Response
    {
        try {
            $postData = $this->request->getJsonRawBody();

            $card = new PurchaseCard([
                'receipt' => $this->clean($postData->receipt),
            ]);

            return $this->response
                ->setPayloadSuccess(['data' => $card])
                ->setStatusCode($this->response::OK);
        } catch (HttpException $ex) {
            return $this->response
                ->setPayloadError($ex->getMessage())
                ->setStatusCode($this->response::OK);
        }
    }

    public function check_subscription(): Response
    {
        try {
            $token = $this->request->getBearerTokenFromHeader();

            return $this->response
                ->setPayloadSuccess(['data' => $token])
                ->setStatusCode($this->response::OK);
        } catch (HttpException $ex) {
            return $this->response
                ->setPayloadError($ex->getMessage())
                ->setStatusCode($this->response::OK);
        }
    }
}
