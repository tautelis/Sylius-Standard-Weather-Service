<?php declare(strict_types=1);

namespace App\Service\Weather;

use App\Entity\Product\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MeteoLtClient implements WeatherClientInterface
{
    public const WEATHER_CONDITION_CLEAR = 'clear';
    public const WEATHER_CONDITION_ISOLATED_CLOUDS = 'isolated-clouds';
    public const WEATHER_CONDITION_SCATTERED_CLOUDS = 'scattered-clouds';
    public const WEATHER_CONDITION_OVERCAST = 'overcast';
    public const WEATHER_CONDITION_LIGHT_RAIN = 'light-rain';
    public const WEATHER_CONDITION_MODERATE_RAIN = 'moderate-rain';
    public const WEATHER_CONDITION_SLEET = 'sleet';
    public const WEATHER_CONDITION_LIGHT_SNOW = 'light-snow';
    public const WEATHER_CONDITION_MODERATE_SNOW = 'moderate-snow';
    public const WEATHER_CONDITION_HEAVY_SNOW = 'heavy-snow';
    public const WEATHER_CONDITION_FOG = 'fog';
    public const WEATHER_CONDITION_NOT_AVAILABLE = 'na';

    private const WEATHER_CONDITION_MAP = [
        // sunny
        self::WEATHER_CONDITION_CLEAR => Product::WEATHER_TYPE_SUNNY,
        self::WEATHER_CONDITION_ISOLATED_CLOUDS => Product::WEATHER_TYPE_SUNNY,
        self::WEATHER_CONDITION_SCATTERED_CLOUDS => Product::WEATHER_TYPE_SUNNY,
        // rainy
        self::WEATHER_CONDITION_LIGHT_RAIN => Product::WEATHER_TYPE_RAINY,
        self::WEATHER_CONDITION_MODERATE_RAIN => Product::WEATHER_TYPE_RAINY,
        self::WEATHER_CONDITION_SLEET => Product::WEATHER_TYPE_RAINY,
        // snowy
        self::WEATHER_CONDITION_LIGHT_SNOW => Product::WEATHER_TYPE_SNOWY,
        self::WEATHER_CONDITION_MODERATE_SNOW => Product::WEATHER_TYPE_SNOWY,
        self::WEATHER_CONDITION_HEAVY_SNOW => Product::WEATHER_TYPE_SNOWY,
    ];

    private const URL = 'https://api.meteo.lt/v1/places/%s/forecasts/long-term';
    private const URL_FORECAST = 'https://api.meteo.lt/v1/places/%s/forecasts/long-term';
    private const URL_VALIDATION = 'https://api.meteo.lt/v1/places/%s';

    /**
     * @var Client
     */
    private $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client([
            'base_uri' => 'https://api.meteo.lt/v1/',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getWeatherCondition(string $locationCode): ?string
    {
        $response = $this->guzzleClient->get(sprintf('places/%s/forecasts/long-term', $locationCode));
        $response = json_decode((string)$response->getBody(), true);

        $conditionCode = $response['forecastTimestamps'][0]['conditionCode'] ?? null;

        return self::WEATHER_CONDITION_MAP[$conditionCode] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function isValidLocationCode(string $locationCode): bool
    {
        try {
            $this->guzzleClient->get(sprintf('places/%s', $locationCode));
        } catch (ClientException $e) {
            return false;
        }

        return true;
    }
}
