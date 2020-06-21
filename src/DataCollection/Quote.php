<?php

declare(strict_types=1);

namespace App\DataCollection;

use Nette\Utils\Strings;

final class Quote
{
    /**
     * @var string
     */
    private $quote;

    public function __construct(string $quote)
    {
        $this->quote = $quote;
    }

    public function getQuote(): string
    {
        return $this->quote;
    }

    public function shoutQuote(): string
    {
        $string = Strings::trim(Strings::upper($this->getQuote()), '.!');

        return sprintf('%s!', $string);
    }
}
