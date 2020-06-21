<?php

declare(strict_types=1);

namespace App\DataCollection;

use App\Exception\NotEnoughQuotesException;

final class Author
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Quote[]
     */
    private $quotes = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addQuote(string $quote): void
    {
        $this->quotes[] = new Quote($quote);
    }

    /**
     * @return string[]
     *
     * @throws NotEnoughQuotesException
     */
    public function shoutQuotes(int $amount): array
    {
        $count = count($this->quotes);
        if ($amount > $count) {
            throw new NotEnoughQuotesException(sprintf(
                'Not enough quotes for given author. Maximum quotes: %s',
                $count
            ));
        }

        $i = 1;
        $quotes = [];
        foreach ($this->quotes as $quote) {
            $quotes[] = $quote->shoutQuote();
            ++$i;

            if ($i > $amount) {
                break;
            }
        }

        return $quotes;
    }
}
