<?php declare(strict_types=1);

namespace Shopware\Api\Snippet\Event\Snippet;

use Shopware\Api\Entity\Search\IdSearchResult;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;

class SnippetIdSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'snippet.id.search.result.loaded';

    /**
     * @var IdSearchResult
     */
    protected $result;

    public function __construct(IdSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->result->getContext();
    }

    public function getResult(): IdSearchResult
    {
        return $this->result;
    }
}
