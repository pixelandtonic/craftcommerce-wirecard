<?php

namespace Wirecard\Functional;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use PHPUnit_Framework_TestCase;

abstract class FunctionalTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer
     */
    protected $serializer;

    protected function setUp()
    {
        parent::setUp();
        $this->serializer = SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/../../src/Serializer/Metadata', 'Wirecard\Element')
            ->build();
    }
}
