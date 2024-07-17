<?php

namespace RetailCrm\Geohelper\Http;

use JsonException;
use RetailCrm\Geohelper\Response\ApiResponse;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class Client
{
    private const HEADERS = [
        'Content-type' => 'application/json',
        'Accept' => 'application/json',
        'Cache-Control' => 'no-cache',
    ];
    protected ClientInterface $client;
    protected string $baseUrl;

    /**
     * @var array<mixed> $defaultParameters
     */
    protected array $defaultParameters;

    /**
     * @param ClientInterface $client
     * @param string $baseUrl
     * @param array<mixed> $defaultParameters
     */
    public function __construct(
        ClientInterface $client,
        string $baseUrl,
        array $defaultParameters = []
    ) {
        if (false === stripos($baseUrl, 'https://')) {
            throw new \InvalidArgumentException(
                'API schema requires HTTPS protocol'
            );
        }

        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->defaultParameters = $defaultParameters;
    }

    /**
     * @param string $methodUrl
     * @param array<mixed> $requestData
     * @return RequestInterface
     * @throws JsonException
     */
    public function buildPostRequest(string $methodUrl, array $requestData = []): RequestInterface
    {
        $requestBody = null;

        if (!empty($requestData)) {
            $requestBody = json_encode(array_merge($requestData, $this->defaultParameters), JSON_THROW_ON_ERROR);
        }

        return new Request(
            'POST',
            new Uri($this->baseUrl . $methodUrl),
            self::HEADERS,
            $requestBody
        );
    }

    /**
     * @param string $methodUrl
     * @param array<mixed> $parameters
     * @return RequestInterface
     */
    public function buildGetRequest(string $methodUrl, array $parameters): RequestInterface
    {
        $body = http_build_query(
            array_merge($parameters, $this->defaultParameters),
            '',
            '&',
            \PHP_QUERY_RFC3986
        );

        return new Request(
            'GET',
            new Uri($this->baseUrl . $methodUrl . '?' . $body),
            self::HEADERS,
            null
        );
    }

    /**
     * @throws ClientExceptionInterface|JsonException
     */
    public function makeRequest(RequestInterface $request): ApiResponse
    {
        $response = $this->client->sendRequest($request);
        $responseBody = (string) $response->getBody();
        $statusCode = $response->getStatusCode();

        return new ApiResponse($statusCode, $responseBody);
    }
}
