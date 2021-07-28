<?php

declare(strict_types=1);

namespace Api\Http;

use Phalcon\Http\Response as PhResponse;
use Phalcon\Http\ResponseInterface;
use Phalcon\Messages\Messages;
use function date;
use function json_decode;
use function sha1;

/**
 * @method setStatusCode($ACCEPTED)
 * @method getJsonRawBody()
 */
class Response extends PhResponse
{
    public const OK                    = 200;
    public const CREATED               = 201;
    public const ACCEPTED              = 202;
    public const MOVED_PERMANENTLY     = 301;
    public const FOUND                 = 302;
    public const TEMPORARY_REDIRECT    = 307;
    public const PERMANENTLY_REDIRECT  = 308;
    public const BAD_REQUEST           = 400;
    public const UNAUTHORIZED          = 401;
    public const FORBIDDEN             = 403;
    public const NOT_FOUND             = 404;
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED       = 501;
    public const BAD_GATEWAY           = 502;

    private $codes = [
        200 => 'OK',
        301 => 'Moved Permanently',
        302 => 'Found',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
    ];

    /**
     * @return int|string
     */
    public function getHttpCodeDescription(int $code)
    {
        if (true === isset($this->codes[$code])) {
            return sprintf('%d (%s)', $code, $this->codes[$code]);
        }

        return $code;
    }

    public function send(): ResponseInterface
    {
        $content   = $this->getContent();
        $timestamp = date('c');
        $hash      = sha1($timestamp . $content);
        $eTag      = sha1($content);

        $content = json_decode($this->getContent(), true);
        $jsonapi = [
            'jsonapi' => [
                'version' => '1.0',
            ],
        ];
        $meta    = [
            'meta' => [
                'timestamp' => $timestamp,
                'hash'      => $hash,
            ]
        ];

        $data = $jsonapi + $content + $meta;
        $this
            ->setHeader('E-Tag', $eTag)
            ->setJsonContent($data);

        return parent::send();
    }

    public function setPayloadError(string $detail = ''): Response
    {
        $this->setJsonContent(['errors' => [$detail]]);

        return $this;
    }

    public function setPayloadErrors($errors): Response
    {
        $data = [];
        foreach ($errors as $error) {
            $data[] = $error->getMessage();
        }

        $this->setJsonContent(['errors' => $data]);

        return $this;
    }

    public function setPayloadSuccess($content = []): Response
    {
        $data = (true === is_array($content)) ? $content : ['data' => $content];
        $data = (true === isset($data['data'])) ? $data : ['data' => $data];

        $this->setJsonContent($data);

        return $this;
    }
}
