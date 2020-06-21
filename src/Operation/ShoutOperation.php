<?php

declare(strict_types=1);

namespace App\Operation;

use App\ApiResource\Shout;
use App\Exception\AuthorNotFoundException;
use App\Exception\InvalidResourceException;
use App\Exception\NotEnoughQuotesException;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ShoutOperation
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @throws AuthorNotFoundException
     * @throws InvalidResourceException
     * @throws NotEnoughQuotesException
     */
    public function shout(Shout $shout): JsonResponse
    {
        $author = $this->authorRepository->getAuthorData($shout->getAuthor());

        return new JsonResponse($author->shoutQuotes($shout->getAmount()));
    }
}
