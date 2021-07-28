<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Component\CardInterface;
use Api\Constants\Filters;
use Phalcon\Exception as HttpException;
use Phalcon\Filter;
use Phalcon\Filter\FilterFactory;
use Phalcon\Mvc\Controller;

use function json_decode;
use function json_encode;
use function str_replace;

abstract class AbstractController extends Controller
{
    abstract public function register();

    abstract public function purchase();

    abstract public function check_subscription();

    protected function clean(string $text): string
    {
        $text = $this->filter->sanitize($text, [
            Filters::FILTER_STRING,
            Filters::FILTER_TRIM
        ]);

        $text = str_replace([" ", "\n", "\t"], "", $text);

        return $text;
    }

    protected function set_token_cache(CardInterface $card): void
    {
        if (! $card instanceof CardInterface) {
            throw new HttpException("Bad Request", $this->response::BAD_REQUEST);
        }

        $cache_id = $this->cacheManager->cache_id([$card->getToken()], "token_");

        $this->cacheManager->set($cache_id, [
            'token'      => $card->getToken(),
            'uid'        => $card->getUid(),
            'app_id'     => $card->getAppId(),
            'token_true' => true,
        ]);

        $this->session->set('token', $card->getToken());
        $this->session->set('uid', $card->getUid());
        $this->session->set('app_id', $card->getAppId());
        $this->session->set('token_true', true);
    }

    protected function get_token_cache(CardInterface $card): bool
    {
        if (! $card instanceof CardInterface) {
            throw new HttpException("Bad Request", $this->response::BAD_REQUEST);
        }

        if (true === $this->session->get('token_true')) {
            return true;
        }

        $cache_id = $this->cacheManager->cache_id([$card->getToken()], "token_");

        $cache = $this->cacheManager->get($cache_id);

        if (false !== $cache) {
            if (true === $cache['token_true']) {
                $this->session->set('token', $cache['token']);
                $this->session->set('uid', $cache['uid']);
                $this->session->set('app_id', $cache['app_id']);
                $this->session->set('token_true', true);
                return true;
            }
        }

        return false;
    }
}
