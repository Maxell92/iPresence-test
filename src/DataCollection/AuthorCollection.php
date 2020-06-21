<?php

declare(strict_types=1);

namespace App\DataCollection;

use App\Exception\AuthorNotFoundException;
use App\Exception\InvalidResourceException;
use Iterator;

final class AuthorCollection implements Iterator
{
    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var Author[]
     */
    private $authors = [];

    /**
     * @var int[]
     */
    private $mapping = [];

    /**
     * @param mixed[] $data
     *
     * @throws InvalidResourceException
     */
    public function __construct(array $data)
    {
        foreach ($data as $item) {
            if (!isset($item['author'], $item['quote'])) {
                throw new InvalidResourceException('Authors cannot be loaded.');
            }

            $author = $this->getOrCreateAuthor($item['author']);
            $author->addQuote($item['quote']);
        }
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function getAuthor(string $author): Author
    {
        if (empty($this->mapping[$author])) {
            throw new AuthorNotFoundException('Author was not found.');
        }

        $key = $this->mapping[$author];

        return $this->authors[$key];
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Author
    {
        return $this->authors[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->authors[$this->position]);
    }

    private function getOrCreateAuthor(string $author): Author
    {
        try {
            return $this->getAuthor($author);
        } catch (AuthorNotFoundException $authorNotFoundException) {
        }

        $newAuthor = new Author($author);
        $this->authors[] = $newAuthor;
        $key = array_key_last($this->authors);
        $this->mapping[$author] = (int) $key;

        return $newAuthor;
    }
}
