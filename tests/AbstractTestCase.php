<?php

namespace RetailCrm\Geohelper;

use PHPUnit\Framework\TestCase;
use Pock\PockBuilder;
use Psr\Http\Client\ClientInterface;

class AbstractTestCase extends TestCase
{
    protected ClientInterface $clientInterface;

    /**
     * @var string
     */
    protected const TEST_API_TOKEN = 'd6f33e419c16131e5325cbd84d5d6000';

    /**
     * @var string
     */
    protected const TEST_API_HOST = 'http://geohelper.test/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientInterface = (new PockBuilder())->getClient();
    }
}
