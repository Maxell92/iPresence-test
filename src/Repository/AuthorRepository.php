<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataCollection\Author;
use App\Exception\AuthorNotFoundException;
use App\Exception\InvalidResourceException;
use App\Source\AuthorFileSource;

final class AuthorRepository
{
    /**
     * @var AuthorFileSource
     */
    private $authorFileSource;

    public function __construct(AuthorFileSource $authorFileSource)
    {
        $this->authorFileSource = $authorFileSource;
    }

    /**
     * @throws AuthorNotFoundException
     * @throws InvalidResourceException
     */
    public function getAuthorData(string $author): Author
    {
        $authors = $this->authorFileSource->getAuthorDataCollection();

        return $authors->getAuthor($author);
    }
}
