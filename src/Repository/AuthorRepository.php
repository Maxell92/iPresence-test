<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataCollection\Author;
use App\Exception\AuthorNotFoundException;
use App\Exception\InvalidResourceException;
use App\Source\AuthorSourceInterface;

final class AuthorRepository
{
    /**
     * @var AuthorSourceInterface
     */
    private $authorSource;

    public function __construct(AuthorSourceInterface $authorSource)
    {
        $this->authorSource = $authorSource;
    }

    /**
     * @throws AuthorNotFoundException
     * @throws InvalidResourceException
     */
    public function getAuthorData(string $author): Author
    {
        $authors = $this->authorSource->getAuthorDataCollection();

        return $authors->getAuthor($author);
    }
}
