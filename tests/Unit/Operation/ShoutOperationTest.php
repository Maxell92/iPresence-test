<?php

declare(strict_types=1);

namespace App\Tests\Unit\Operation;

use App\ApiResource\Shout;
use App\Cache\ShoutCache;
use App\DataCollection\Author;
use App\Exception\NoCachedItemException;
use App\Operation\ShoutOperation;
use App\Repository\AuthorRepository;
use PHPUnit\Framework\TestCase;

final class ShoutOperationTest extends TestCase
{
    public function testCacheWasHit(): void
    {
        $authorRepository = $this->createMock(AuthorRepository::class);
        $authorRepository->expects($this->never())
            ->method('getAuthorData');

        $shoutCache = $this->createMock(ShoutCache::class);
        $shoutCache->expects($this->once())
            ->method('getContent')
            ->with('Author', 1)
            ->willReturn(['SHOUTING!']);

        $shout = new Shout();
        $shout->setAuthor('Author');
        $shout->setAmount(1);

        $shoutOperation = new ShoutOperation($authorRepository, $shoutCache);
        $shoutOperation->shout($shout);
    }

    public function testCacheWasNotHit(): void
    {
        $author = new Author('Author');
        $author->addQuote('quote');

        $authorRepository = $this->createMock(AuthorRepository::class);
        $authorRepository->expects($this->once())
            ->method('getAuthorData')
            ->with('Author')
            ->willReturn($author);

        $shoutCache = $this->createMock(ShoutCache::class);
        $shoutCache->expects($this->once())
            ->method('getContent')
            ->with('Author', 1)
            ->willThrowException(new NoCachedItemException());
        $shoutCache->expects($this->once())
            ->method('setContent')
            ->with('Author', 1, ['QUOTE!']);

        $shout = new Shout();
        $shout->setAuthor('Author');
        $shout->setAmount(1);

        $shoutOperation = new ShoutOperation($authorRepository, $shoutCache);
        $shoutOperation->shout($shout);
    }
}
