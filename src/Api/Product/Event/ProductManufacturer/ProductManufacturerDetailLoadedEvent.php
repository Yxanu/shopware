<?php declare(strict_types=1);

namespace Shopware\Api\Product\Event\ProductManufacturer;

use Shopware\Api\Media\Event\Media\MediaBasicLoadedEvent;
use Shopware\Api\Product\Collection\ProductManufacturerDetailCollection;
use Shopware\Api\Product\Event\Product\ProductBasicLoadedEvent;
use Shopware\Api\Product\Event\ProductManufacturerTranslation\ProductManufacturerTranslationBasicLoadedEvent;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class ProductManufacturerDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'product_manufacturer.detail.loaded';

    /**
     * @var ShopContext
     */
    protected $context;

    /**
     * @var ProductManufacturerDetailCollection
     */
    protected $productManufacturers;

    public function __construct(ProductManufacturerDetailCollection $productManufacturers, ShopContext $context)
    {
        $this->context = $context;
        $this->productManufacturers = $productManufacturers;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->context;
    }

    public function getProductManufacturers(): ProductManufacturerDetailCollection
    {
        return $this->productManufacturers;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->productManufacturers->getMedia()->count() > 0) {
            $events[] = new MediaBasicLoadedEvent($this->productManufacturers->getMedia(), $this->context);
        }
        if ($this->productManufacturers->getProducts()->count() > 0) {
            $events[] = new ProductBasicLoadedEvent($this->productManufacturers->getProducts(), $this->context);
        }
        if ($this->productManufacturers->getTranslations()->count() > 0) {
            $events[] = new ProductManufacturerTranslationBasicLoadedEvent($this->productManufacturers->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
