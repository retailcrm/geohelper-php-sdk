<?php

namespace RetailCrm\Geohelper\Http;

use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Pock\PockBuilder;

class ClientTest extends TestCase
{
    protected const METHOD = '/test';
    protected const TEST_DATA = [
        'data' => 'test'
    ];
    protected const TEST_API_HOST = 'http://geohelper.test/';
    private Client $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client((new PockBuilder())->getClient(), self::TEST_API_HOST);
    }

    public function testBuildPostRequest(): void
    {
        $request = $this->client->buildPostRequest(self::METHOD, self::TEST_DATA);
        self::assertInstanceOf(Request::class, $request);
        self::assertEquals('POST', $request->getMethod());
    }

    public function testBuildGetRequest(): void
    {
        $parameters = http_build_query(
            self::TEST_DATA,
            '',
            '&',
            \PHP_QUERY_RFC3986
        );
        $request = $this->client->buildGetRequest(self::METHOD, self::TEST_DATA);
        self::assertInstanceOf(Request::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            self::TEST_API_HOST . self::METHOD . '?' . $parameters,
            $request->getUri()->__toString()
        );
    }
}
