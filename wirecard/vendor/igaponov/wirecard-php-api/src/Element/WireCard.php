<?php

namespace Wirecard\Element;

class WireCard
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    public static function createWithResponse(Response $response)
    {
        $card = new self;
        $card->response = $response;

        return $card;
    }

    public static function createWithRequest(Request $request)
    {
        $card = new self;
        $card->request = $request;

        return $card;
    }

    private function __construct()
    {

    }
}
