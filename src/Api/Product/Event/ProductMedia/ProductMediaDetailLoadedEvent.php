<?php declare(strict_types=1);

namespace Shopware\Api\Product\Event\ProductMedia;

use Shopware\Api\Media\Event\Media\MediaBasicLoadedEvent;
use Shopware\Api\Product\Collection\ProductMediaDetailCollection;
use Shopware\Api\Product\Event\Product\ProductBasicLoadedEvent;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class ProductMediaDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'product_media.detail.loaded';

    /**
     * @var ShopContext
     */
    protected $context;

    /**
     * @var ProductMediaDetailCollection
     */
    protected $productMedia;

    public function __construct(ProductMediaDetailCollection $productMedia, ShopContext $context)
    {
        $this->context = $context;
        $this->productMedia = $productMedia;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->context;
    }

    public function getProductMedia(): ProductMediaDetailCollection
    {
        return $this->productMedia;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->productMedia->getProducts()->count() > 0) {
            $events[] = new ProductBasicLoadedEvent($this->productMedia->getProducts(), $this->context);
        }
        if ($this->productMedia->getMedia()->count() > 0) {
            $events[] = new MediaBasicLoadedEvent($this->productMedia->getMedia(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
