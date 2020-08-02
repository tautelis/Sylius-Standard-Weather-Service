<?php declare(strict_types=1);

namespace App\Service\Weather;

interface WeatherClientInterface
{
    /**
     * @param string $city
     *
     * @return string|null
     */
    public function getWeatherCondition(string $city): ?string;

    /**
     * @param string $city
     *
     * @return bool
     */
    public function isValidLocationCode(string $city): bool;
}
