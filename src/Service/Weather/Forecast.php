<?php declare(strict_types=1);

namespace App\Service\Weather;

class Forecast
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $condition;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Forecast
     */
    public function setCode(string $code): Forecast
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     * @return Forecast
     */
    public function setCondition(string $condition): Forecast
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     * @return Forecast
     */
    public function setTemperature(float $temperature): Forecast
    {
        $this->temperature = $temperature;

        return $this;
    }
}
