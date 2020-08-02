<?php declare(strict_types=1);

namespace App\Service\Weather;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class WeatherService
{
    public const SESSION_KEY = 'WEATHER_SERVICE_LOCATION_CODE';

    /** @var SessionInterface */
    private $session;
    /** @var WeatherClientInterface */
    private $weatherClient;

    /**
     * @param SessionInterface $session
     * @param WeatherClientInterface $weatherClient
     */
    public function __construct(SessionInterface $session, WeatherClientInterface $weatherClient)
    {
        $this->session = $session;
        $this->weatherClient = $weatherClient;
    }

    /**
     * @return string
     */
    public function getWeatherCondition(): string
    {
        return $this->weatherClient->getWeatherCondition($this->session->get(self::SESSION_KEY));
    }

    /**
     * @param string $locationName
     *
     * @return bool
     */
    public function isValid(string $locationName)
    {
        return $this->weatherClient->isValidLocationCode($locationName);
    }
}
