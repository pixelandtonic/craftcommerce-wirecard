<?php

namespace Wirecard\Element;

class Secure
{
    public $request;

    public $response;

    public $url;

    /**
     * @param $request
     * @param null $url
     * @return Secure
     */
    public static function createRequest($request, $url = null)
    {
        $secure = new self($url);
        $secure->request = $request;

        return $secure;
    }

    /**
     * @param $response
     * @param null $url
     * @return Secure
     */
    public static function createResponse($response, $url = null)
    {
        $secure = new self($url);
        $secure->response = $response;

        return $secure;
    }

    private function __construct($url)
    {
        $this->url = $url;
    }
}
 