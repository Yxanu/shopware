<?php declare(strict_types=1);

namespace Shopware\Api\Country\Event\Country;

use Shopware\Api\Country\Collection\CountryBasicCollection;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;

class CountryBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'country.basic.loaded';

    /**
     * @var ShopContext
     */
    protected $context;

    /**
     * @var CountryBasicCollection
     */
    protected $countries;

    public function __construct(CountryBasicCollection $countries, ShopContext $context)
    {
        $this->context = $context;
        $this->countries = $countries;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->context;
    }

    public function getCountries(): CountryBasicCollection
    {
        return $this->countries;
    }
}
