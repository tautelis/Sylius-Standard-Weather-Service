<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="sylius_product",
 *     indexes={@ORM\Index(name="weather_idx", columns={"weather_type"})}
 * )
 */
class Product extends BaseProduct
{
    public const WEATHER_TYPE_SUNNY = 'sunny';
    public const WEATHER_TYPE_RAINY = 'rainy';
    public const WEATHER_TYPE_SNOWY = 'snowy';

    /**
     * @ORM\Column(type="string", name="weather_type", nullable=true, length=16)
     */
    private $weatherType;

    public function getWeatherType(): ?string
    {
        return $this->weatherType;
    }

    public function setWeatherType(string $weatherType): void
    {
        $this->weatherType = $weatherType;
    }

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }
}
