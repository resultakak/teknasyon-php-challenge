<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Component\RegisterCard;
use Api\Constants\Filters;
use Api\Http\Response;
use Api\Models\Devices;
use Api\Traits\ResponseTrait;
use Phalcon\Filter;
use Phalcon\Filter\FilterFactory;
use Phalcon\Mvc\Controller;

class ApiController extends Controller
{
    use ResponseTrait;

    public function register(): Response
    {
        $postData = $this->request->getJsonRawBody();

        $card = new RegisterCard([
            'uid'      => $this->filter->sanitize(trim($postData->uid), Filters::FILTER_STRING),
            'app_id'   => $this->filter->sanitize(trim($postData->app_id), Filters::FILTER_STRING),
            'language' => $this->filter->sanitize(trim($postData->language), Filters::FILTER_STRING),
            'os'       => $this->filter->sanitize(trim($postData->os), Filters::FILTER_STRING),
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
    }

    public function purchase(): Response
    {
        return $this->response
            ->setPayloadSuccess(['data' => 'purchase'])
            ->setStatusCode($this->response::OK);
    }

    public function check_subscription(): Response
    {
        return $this->response
            ->setPayloadSuccess(['data' => 'check_subscription'])
            ->setStatusCode($this->response::OK);
    }
}
