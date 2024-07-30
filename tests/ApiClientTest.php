<?php

namespace RetailCrm\Geohelper;

use PHPUnit\Framework\TestCase;
use Pock\Client;
use Pock\Enum\RequestMethod;
use Pock\Enum\RequestScheme;
use Pock\Exception\JsonException;
use Pock\PockBuilder;

class ApiClientTest extends TestCase
{
    protected const TEST_API_TOKEN = 'd6f33e419c16131e5325cbd84d5d6000';
    protected const TEST_API_URL = 'https://geohelper.info/';
    protected const TEST_API_HOST = 'geohelper.info';
    private ApiClient $apiClient;

    /**
     * @param array<mixed> $data
     *
     * @throws JsonException
     */
    public function getClientInterface(array $data): Client
    {
        $builder = new PockBuilder();
        $builder
            ->matchMethod($data['method'])
            ->matchPath('/api/v1' . $data['path'])
            ->matchScheme(RequestScheme::HTTPS)
            ->matchHost(self::TEST_API_HOST)
            ->reply($data['responseCode'])
            ->withHeader('Content-Type', 'application/json')
            ->withJson($data['response'])
        ;

        return $builder->getClient();
    }

    public function testCitiesList(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                [
                    'id' => 5424243,
                    'name' => '10-й Блок-Пост',
                    'localityType' => [
                        'code' => 'city-village',
                        'name' => 'деревня',
                        'localizedNamesShort' => [
                            'en' => 'vil.',
                            'ru' => 'д.',
                        ],
                        'localizedNames' => [
                            'en' => 'village',
                            'ru' => 'деревня',
                        ],
                    ],
                    'area' => 'Пищаловский',
                    'codes' => [
                        'soato' => '2236858006',
                    ],
                    'regionId' => 3941,
                    'localizedNames' => [
                        'en' => '10th Blok-Post',
                        'ru' => '10-й Блок-Пост',
                    ],
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/cities',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->citiesList();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testCountriesList(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                [
                    'id' => 12,
                    'name' => 'Австралия',
                    'iso' => 'AU',
                    'iso3' => 'AUS',
                    'isoNumeric' => '036',
                    'fips' => 'AS',
                    'continent' => 'OC',
                    'currencyCode' => 'AUD',
                    'phonePrefix' => [
                        '61',
                    ],
                    'postalCodeFormat' => '####',
                    'postalCodeRegex' => "^(\d{4})$",
                    'languages' => [
                        'en-AU',
                    ],
                    'externalIds' => [
                        'geonames' => '2077456',
                    ],
                    'localizedNames' => [
                        'en' => 'Australia',
                        'es' => 'Australia',
                        'nl' => 'Australië',
                        'ro' => 'Australia',
                        'ru' => 'Австралия',
                        'uk' => 'Австралія',
                    ],
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/countries',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->countriesList();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testRegionsList(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                [
                    'timezoneOffset' => 10800,
                    'countryIso' => 'BY',
                    'id' => 3940,
                    'name' => 'Брестская область',
                    'codes' => [
                        'iso' => 'BY-BR',
                        'fips' => '01',
                    ],
                    'localityType' => [
                        'code' => 'region-oblast',
                        'name' => 'область',
                        'localizedNamesShort' => [
                            'en' => 'obl.',
                            'kz' => 'обл.',
                            'ru' => 'обл.',
                        ],
                        'localizedNames' => [
                            'en' => 'oblast',
                            'kz' => 'облысы',
                            'ru' => 'область',
                        ],
                    ],
                    'timezone' => 'Europe/Minsk',
                    'countryId' => 33,
                    'externalIds' => [
                        'geonames' => '629631',
                    ],
                    'localizedNames' => [
                        'en' => 'Brestskaya',
                        'ru' => 'Брестская',
                    ],
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/regions',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->regionsList();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testStreetsList(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                [
                    'id' => 3027268,
                    'name' => '1 Линия',
                    'codes' => [
                        'kladr' => '01000001000082600',
                    ],
                    'cityId' => 1,
                    'parentStreetId' => 3019517,
                    'localityType' => [
                        'code' => 'street-street',
                        'name' => 'улица',
                        'localizedNamesShort' => [
                            'en' => 'st.',
                            'es' => 'c.',
                            'kz' => 'көш.',
                            'ro' => 'str.',
                            'ru' => 'ул.',
                            'uk' => 'вул.',
                        ],
                        'localizedNames' => [
                            'en' => 'street',
                            'es' => 'calle',
                            'kz' => 'көшеci',
                            'ro' => 'strada',
                            'ru' => 'улица',
                            'uk' => 'вулиця',
                        ],
                    ],
                    'externalIds' => [
                        'fias' => '5a99511c-7020-4bc4-b54d-bb647ee6aeb9',
                        'fias_gar' => '924',
                    ],
                    'localizedNames' => [
                        'en' => '1 Liniya',
                        'ru' => '1 Линия',
                    ],
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/streets',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->streetsList();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testPhoneDataGet(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                'dataSource' => 'rossvyaz',
                'abcDefCode' => 0,
                'rangeStart' => 79001960000,
                'rangeEnd' => 79001969999,
                'providerName' => 'ООО "Т2 Мобайл"',
                'region' => [
                    'timezoneOffset' => 10800,
                    'countryIso' => 'RU',
                    'id' => 41,
                    'name' => 'Ингушетия',
                    'codes' => [
                        'iso' => 'RU-IN',
                        'fias' => '06',
                        'fips' => '19',
                        'kladr' => '0600000000000',
                    ],
                    'localityType' => [
                        'code' => 'region-republic',
                        'localizedNamesShort' => [
                            'en' => 'rep.',
                            'ru' => 'респ.',
                        ],
                        'localizedNames' => [
                            'en' => 'Republic',
                            'kz' => 'Республикасы',
                            'ru' => 'Республика',
                        ],
                    ],
                    'timezone' => 'Europe/Moscow',
                    'countryId' => 189,
                    'externalIds' => [
                        'fias' => 'b2d8cd20-cabc-4deb-afad-f3c4b4d55821',
                        'fias_gar' => '103401',
                        'geonames' => '556349',
                    ],
                    'localizedNames' => [
                        'en' => 'Ingushetiya',
                        'ru' => 'Ингушетия',
                    ],
                ],
                'phoneParts' => [
                    'countryCode' => '7',
                    'code' => '90',
                    'number' => '01960001',
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/phone-data',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->phoneDataGet();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testPhoneDataList(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                [
                    'dataSource' => 'rossvyaz',
                    'abcDefCode' => 0,
                    'rangeStart' => 79001960000,
                    'rangeEnd' => 79001969999,
                    'providerName' => 'ООО "Т2 Мобайл"',
                    'region' => [
                        'timezoneOffset' => 10800,
                        'countryIso' => 'RU',
                        'id' => 41,
                        'name' => 'Ингушетия',
                        'codes' => [
                            'iso' => 'RU-IN',
                            'fias' => '06',
                            'fips' => '19',
                            'kladr' => '0600000000000',
                        ],
                        'localityType' => [
                            'code' => 'region-republic',
                            'localizedNamesShort' => [
                                'en' => 'rep.',
                                'ru' => 'респ.',
                            ],
                            'localizedNames' => [
                                'en' => 'Republic',
                                'kz' => 'Республикасы',
                                'ru' => 'Республика',
                            ],
                        ],
                        'timezone' => 'Europe/Moscow',
                        'countryId' => 189,
                        'externalIds' => [
                            'fias' => 'b2d8cd20-cabc-4deb-afad-f3c4b4d55821',
                            'fias_gar' => '103401',
                            'geonames' => '556349',
                        ],
                        'localizedNames' => [
                            'en' => 'Ingushetiya',
                            'ru' => 'Ингушетия',
                        ],
                    ],
                    'phoneParts' => [
                        'countryCode' => '7',
                        'code' => '90',
                        'number' => '01960001',
                    ],
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::POST,
            'path' => '/phone-collection-data',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->phoneDataList();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testServiceLocalityGet(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => [
                [
                    'innerId' => 334789,
                    'country' => [
                        'id' => 189,
                        'name' => 'Россия',
                        'iso' => 'RU',
                        'iso3' => 'RUS',
                        'isoNumeric' => '643',
                        'fips' => 'RS',
                        'continent' => 'EU',
                        'currencyCode' => 'RUB',
                        'phonePrefix' => [
                            '7',
                        ],
                        'postalCodeFormat' => '######',
                        'postalCodeRegex' => "^(\d{6})$",
                        'languages' => [
                            'ru',
                            'tt',
                            'xal',
                            'cau',
                            'ady',
                            'kv',
                            'ce',
                            'tyv',
                            'cv',
                            'udm',
                            'tut',
                            'mns',
                            'bua',
                            'myv',
                            'mdf',
                            'chm',
                            'ba',
                            'inh',
                            'kbd',
                            'krc',
                            'av',
                            'sah',
                            'nog',
                        ],
                        'externalIds' => [
                            'geonames' => '2017370',
                        ],
                        'localizedNames' => [
                            'en' => 'Russia',
                            'es' => 'Rusia',
                            'nl' => 'Rusland',
                            'ro' => 'Federația Rusă',
                            'ru' => 'Россия',
                            'uk' => 'Росія',
                        ],
                    ],
                    'service' => 'yandex',
                    'externalId' => '134192',
                    'name' => '1-е Комиссаровское',
                    'localityType' => 'city',
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/service-locality',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->serviceLocalityGet();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testPostCodeGet(): void
    {
        $expectedResponse = [
            'success' => true,
            'language' => 'ru',
            'result' => '452451',
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/post-code',
            'responseCode' => 200,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->postCodeGet();
        self::assertEquals($expectedResponse['result'], $response->offsetGet('result'));
    }

    public function testError(): void
    {
        $expectedResponse = [
            'success' => false,
            'error' => [
                'message' => 'Validation failed with 1 error(s).',
                'code' => 1,
                'details' => [
                    'filter.phone: Значение слишком короткое. Должно быть равно 10 символам или больше.',
                ],
            ],
        ];
        $clientInterface = $this->getClientInterface([
            'method' => RequestMethod::GET,
            'path' => '/phone-data',
            'responseCode' => 400,
            'response' => json_encode($expectedResponse, JSON_THROW_ON_ERROR),
        ]);
        $this->apiClient = new ApiClient($clientInterface, self::TEST_API_TOKEN);
        $response = $this->apiClient->phoneDataGet();
        self::assertEquals($expectedResponse['error']['message'], $response->getErrorMsg());
    }
}
