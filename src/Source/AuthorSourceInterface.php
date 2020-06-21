<?php

declare(strict_types=1);

namespace App\Source;

use App\DataCollection\AuthorCollection;

interface AuthorSourceInterface
{
    public function getAuthorDataCollection(): AuthorCollection;
}
