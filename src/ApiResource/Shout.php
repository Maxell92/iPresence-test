<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"post"={
 *           "swagger_context"={
 *     			"summary"="Get quotes for given person",
 *     			"description"="",
 *     			"consumes"={
 *     				"application/json"
 *     			},
 *     			"produces"={
 *     				"application/json"
 *     			},
 *     			"responses"={
 *     				"200"={
 *	 					"description"="OK"
 * 					}
 * 				}
 *	 		 }
 *     }},
 *     itemOperations={}
 * )
 */
final class Shout
{
	/**
	 * @ApiProperty(identifier=true)
	 *
	 * Identifier has to be provided for API Platform even if we do not use it.
	 *
	 * @var string
	 */
	private $id = 'Shout';

	/**
	 * @var string
	 *
	 * @Assert\NotNull
	 */
	private $author;

	/**
	 * @var int
	 *
	 * @Assert\NotNull
     * @Assert\LessThanOrEqual(10)
     * @Assert\GreaterThan(0)
	 */
	private $amount;

	public function getId(): string
	{
		return $this->id;
	}

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $artist): void
    {
        $this->author = $artist;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
