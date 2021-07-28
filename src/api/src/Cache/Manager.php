<?php

declare(strict_types=1);

namespace Api\Cache;

use Phalcon\Mvc\Micro;
use function getenv;
use function json_encode;
use function json_decode;
use function md5;

class Manager
{
    /**
     * @var Micro $application
     */
    protected $application;

    /**
     * Manager constructor.
     *
     * @param Micro $application
     */
    public function __construct(Micro $application)
    {
        $this->application = $application;
    }

    /**
     * @param array  $keys
     * @param string $prefix
     * @return false|string
     * @throws \JsonException
     */
    public function cache_id($keys = [], $prefix = "cm_")
    {
        if (is_array($keys)) {
            $keys[] = getenv('APP_KEY');
        }

        return true === isset($keys) ? $prefix.md5(json_encode($keys, JSON_THROW_ON_ERROR)) : false;
    }

    /**
     * @throws \JsonException
     */
    public function set($key, $value)
    {
        $value = json_encode($value, JSON_THROW_ON_ERROR);
        $this->application->session->set($key, $value);
        $this->application->cache->set($key, $value);
    }

    /**
     * @param $key
     * @return false|mixed
     * @throws \JsonException
     */
    public function get($key)
    {
        $result = $this->application->session->get($key);

        if (! isset($result) || empty($result)) {
            $result = $this->application->cache->get($key);
            if (isset($result) && ! empty($result)) {
                $this->application->session->set($key, $result);
            }
        }

        if (isset($result) && ! empty($result)) {
            $result = json_decode($result, true, 512, JSON_THROW_ON_ERROR);
        }

        return true === isset($result) ? $result : false;
    }
}
