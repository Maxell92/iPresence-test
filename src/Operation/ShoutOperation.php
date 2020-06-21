<?php

declare(strict_types=1);

namespace App\Operation;

use App\ApiResource\Shout;
use App\Cache\ShoutCache;
use App\Exception\AuthorNotFoundException;
use App\Exception\InvalidResourceException;
use App\Exception\NoCachedItemException;
use App\Exception\NotEnoughQuotesException;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ShoutOperation
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @var ShoutCache
     */
    private $shoutCache;

    public function __construct(AuthorRepository $authorRepository, ShoutCache $shoutCache)
    {
        $this->authorRepository = $authorRepository;
        $this->shoutCache = $shoutCache;
    }

    /**
     * @throws AuthorNotFoundException
     * @throws InvalidResourceException
     * @throws NotEnoughQuotesException
     */
    public function shout(Shout $shout): JsonResponse
    {
        try {
            $quotes = $this->shoutCache->getContent($shout->getAuthor(), $shout->getAmount());

            return new JsonResponse($quotes);
        } catch (NoCachedItemException $noCachedItemException) {
        }

        $author = $this->authorRepository->getAuthorData($shout->getAuthor());

        $quotes = $author->shoutQuotes($shout->getAmount());

        $this->shoutCache->setContent($shout->getAuthor(), $shout->getAmount(), $quotes);

        return new JsonResponse($quotes);
    }
}
