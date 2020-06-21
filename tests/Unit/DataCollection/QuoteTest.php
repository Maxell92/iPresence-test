<?php

declare(strict_types=1);

namespace App\Tests\Unit\DataCollection;

use App\DataCollection\Quote;
use PHPUnit\Framework\TestCase;

final class QuoteTest extends TestCase
{
	/**
	 * @dataProvider invalidDatesProvider
	 */
	public function testDateValidatorNotValid(string $string, string $expeted): void
	{
	    $quote = new Quote($string);
		$this->assertSame($expeted, $quote->shoutQuote());
	}

	/**
	 * @return mixed[]
	 */
	public function invalidDatesProvider(): array
	{
		return [
			['.Dream. with dots.', 'DREAM. WITH DOTS!'],
			['Question mark in the end!', 'QUESTION MARK IN THE END!'],
			['don’t try.', 'DON’T TRY!'],
			['Nothing is impossible, the word itself says, “I’m possible!”', 'NOTHING IS IMPOSSIBLE, THE WORD ITSELF SAYS, “I’M POSSIBLE!”!'],
			['No interpunction', 'NO INTERPUNCTION!'],
			['More dots....', 'MORE DOTS!'],
			['More exclamation marks!!!', 'MORE EXCLAMATION MARKS!'],
		];
	}
}
