<?php

declare(strict_types=1);

namespace App\Source;

use App\DataCollection\AuthorCollection;
use App\Exception\InvalidResourceException;

final class AuthorFileSource
{
    /**
     * @var string
     */
    private $resource;

    public function __construct(string $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @throws InvalidResourceException
     */
    public function getAuthorDataCollection(): AuthorCollection
    {
        $fp = fopen($this->resource, 'rb');
        if (!$fp) {
            throw new InvalidResourceException('Authors cannot be loaded.');
        }
        $content = fread($fp, (int) filesize($this->resource));
        fclose($fp);

        if (!$content) {
            throw new InvalidResourceException('Authors cannot be loaded.');
        }

        $data = json_decode($content, true);

        if (empty($data['quotes'])) {
            throw new InvalidResourceException('Authors cannot be loaded.');
        }

        return new AuthorCollection($data['quotes']);
    }
}
