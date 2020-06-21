<?php

declare(strict_types=1);

namespace App\Cache;

use App\Exception\NoCachedItemException;
use Nette\Utils\Strings;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

final class ShoutCache
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return string[]
     *
     * @throws NoCachedItemException
     */
    public function getContent(string $author, int $amount): array
    {
        $item = $this->getItem($author, $amount);
        if (! $item->isHit()) {
            throw new NoCachedItemException();
        }

        return $item->get();
    }

    /**
     * @param string[] $quotes
     */
    public function setContent(string $author, int $amount, array $quotes): void
    {
        $item = $this->getItem($author, $amount);
        $item->set($quotes);
        $this->cache->save($item);
    }

    private function getItem(string $author, int $amount): CacheItem
    {
        $name = Strings::webalize($author).'_'.$amount;

        return $this->cache->getItem($name);
    }
}
