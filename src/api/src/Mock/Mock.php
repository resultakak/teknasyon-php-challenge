<?php

declare(strict_types=1);

namespace Api\Mock;

use function base64_encode;

class Mock
{
    public const IOS = 'ios';

    public const ANDROID = 'android';

    /**
     * @var string $url
     */
    private string $url;

    /**
     * @var string $platform
     */
    private string $platform;

    /**
     * @var string $username
     */
    private string $username;

    /**
     * @var string $password
     */
    private string $password;

    /**
     * @var mixed $post
     */
    private $post;

    /**
     * @var MockResultCard
     */
    private MockResultCard $result;

    public function __construct(array $options = null)
    {
        if (array_key_exists('url', $options)) {
            $this->setUrl($options['url']);
        }
    }

    /**
     * @return $this
     */
    public function handle(): self
    {
        $this->api();

        return $this;
    }

    /**
     * @return bool
     */
    protected function api(): bool
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $this->getUrl(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($this->getPost(), JSON_THROW_ON_ERROR),
            CURLOPT_HTTPHEADER     => array(
                'Authorization: Basic ' . $this->getAuth(),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if (false === $response) {
            return false;
        }

        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (isset($response['data']) && ! empty($response['data'])) {
            $this->setResult($response['data']);
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getAuth(): string
    {
        return base64_encode($this->getUsername().":".$this->getPassword());
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     * @return $this
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return str_replace('{platform}', $this->getPlatform(), $this->url);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @param array $post
     * @return $this
     */
    public function setPost(array $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return MockResultCard
     */
    public function getResult(): MockResultCard
    {
        return $this->result;
    }

    /**
     * @param array $result
     * @return $this
     */
    public function setResult(array $result): self
    {
        $this->result = new MockResultCard($result);

        return $this;
    }
}
