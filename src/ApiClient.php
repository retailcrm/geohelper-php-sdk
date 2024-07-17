<?php

namespace RetailCrm\Geohelper;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use RetailCrm\Geohelper\Http\Client;
use RetailCrm\Geohelper\Response\ApiResponse;

class ApiClient
{
    private const VERSION = 'v1';
    private const URL = 'https://geohelper.info/';

    protected Client $client;

    public function __construct(
        ClientInterface $client,
        string $apiKey
    ) {
        $url = sprintf('%sapi/%s', self::URL, self::VERSION);

        $this->client = new Client($client, $url, ['apiKey' => $apiKey]);
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @param array<mixed> $pagination
     * @param array<mixed> $order
     * @return array<mixed>
     */
    private function getParameters(
        array $filter = [],
        array $locale = [],
        array $pagination = [],
        array $order = []
    ): array {
        $parameters = [];

        if (count($filter)) {
            $parameters['filter'] = $filter;
        }

        if (count($locale)) {
            $parameters['locale'] = $locale;
        }

        if (count($pagination)) {
            $parameters['pagination'] = $pagination;
        }

        if (count($order)) {
            $parameters['order'] = $order;
        }
        return $parameters;
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @param array<mixed> $pagination
     * @param array<mixed> $order
     * @throws ClientExceptionInterface
     */
    public function citiesList(
        array $filter = [],
        array $locale = ['lang' => 'ru'],
        array $pagination = ['page' => 1, 'limit' => 20],
        array $order = []
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/cities',
                $this->getParameters($filter, $locale, $pagination, $order)
            )
        );
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @param array<mixed> $pagination
     * @param array<mixed> $order
     * @throws ClientExceptionInterface
     */
    public function countriesList(
        array $filter = [],
        array $locale = ['lang' => 'ru'],
        array $pagination = ['page' => 1, 'limit' => 20],
        array $order = []
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/countries',
                $this->getParameters($filter, $locale, $pagination, $order)
            )
        );
    }


    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @param array<mixed> $pagination
     * @param array<mixed> $order
     * @throws ClientExceptionInterface
     */
    public function regionsList(
        array $filter = [],
        array $locale = ['lang' => 'ru'],
        array $pagination = ['page' => 1, 'limit' => 20],
        array $order = []
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/regions',
                $this->getParameters($filter, $locale, $pagination, $order)
            )
        );
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @param array<mixed> $pagination
     * @param array<mixed> $order
     * @throws ClientExceptionInterface
     */
    public function streetsList(
        array $filter = [],
        array $locale = ['lang' => 'ru'],
        array $pagination = ['page' => 1, 'limit' => 20],
        array $order = []
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/streets',
                $this->getParameters($filter, $locale, $pagination, $order)
            )
        );
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @throws ClientExceptionInterface
     */
    public function phoneDataGet(
        array $filter = [],
        array $locale = ['lang' => 'ru']
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/phone-data',
                $this->getParameters($filter, $locale)
            )
        );
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @return ApiResponse
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function phoneDataList(
        array $filter = [],
        array $locale = ['lang' => 'ru']
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildPostRequest(
                '/phone-collection-data',
                $this->getParameters($filter, $locale)
            )
        );
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @param array<mixed> $pagination
     * @param array<mixed> $order
     * @throws ClientExceptionInterface
     */
    public function serviceLocalityGet(
        array $filter = [],
        array $locale = ['lang' => 'ru'],
        array $pagination = ['page' => 1, 'limit' => 20],
        array $order = []
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/service-locality',
                $this->getParameters($filter, $locale, $pagination, $order)
            )
        );
    }

    /**
     * @param array<mixed> $filter
     * @param array<mixed> $locale
     * @throws ClientExceptionInterface
     */
    public function postCodeGet(
        array $filter = [],
        array $locale = ['lang' => 'ru']
    ): Response\ApiResponse {
        return $this->client->makeRequest(
            $this->client->buildGetRequest(
                '/post-code',
                $this->getParameters($filter, $locale)
            )
        );
    }
}
