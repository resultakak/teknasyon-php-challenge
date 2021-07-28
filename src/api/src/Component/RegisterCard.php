<?php

declare(strict_types=1);

namespace Api\Component;

use Api\Traits\SerializeTrait;
use JsonSerializable;
use function md5;
use function sha1;
use function json_encode;
use function json_decode;

class RegisterCard implements JsonSerializable, CardInterface
{
    use SerializeTrait;

    /**
     * @var $uid;
     */
    protected $uid;

    /**
     * @var $app_id
     */
    protected $app_id;

    /**
     * @var $language
     */
    protected $language;

    /**
     * @var $os
     */
    protected $os;

    /**
     * @var $created
     */
    protected $created;

    /**
     * @var $token
     */
    private $token;

    /**
     * RegisterCard constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $data = json_decode(json_encode($data), true);

        if (!isset($data) || empty($data) || !is_array($data)) {
            return;
        }

        if (array_key_exists('uid', $data)) {
            $this->setUid($data['uid']);
        }

        if (array_key_exists('app_id', $data)) {
            $this->setAppId($data['app_id']);
        }

        if (array_key_exists('language', $data)) {
            $this->setLanguage($data['language']);
        }

        if (array_key_exists('os', $data)) {
            $this->setOs($data['os']);
        }

        if (array_key_exists('created', $data)) {
            $this->setCreated($data['created']);
        }

        if ($this->getUid() && $this->getAppId()) {
            $this->setToken();
        }
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid): void
    {
        $this->uid = $uid ?? null;
    }

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->app_id;
    }

    /**
     * @param string $app_id
     */
    public function setAppId(string $app_id): void
    {
        $this->app_id = $app_id ?? null;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * @param string $os
     */
    public function setOs(string $os): void
    {
        $this->os = $os;
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @param string $created
     */
    public function setCreated(string $created): void
    {
        $this->created = $created;
    }

    /**
     *
     */
    public function setToken(): void
    {
        $data = [
            'uid'    => sha1($this->encode($this->getUid())),
            'app_id' => sha1($this->encode($this->getAppId())),
            'key'    => sha1(getenv('APP_KEY'))
        ];

        $this->token = md5(sha1(json_encode($data)));
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token ?? "";
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'uid'    => $this->getUid(),
            'app_id' => $this->getAppId(),
            'token' => $this->getToken(),
        ];
    }
}
