<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\Api\Base\BaseTestCase;

final class ShoutTest extends BaseTestCase
{
    public function testValidRequestEinsteinOne(): void
    {
        $request = [
            'author' => 'Albert Einstein',
            'amount' => 1,
        ];

        $data = $this->getValidPostResponse('/api/shouts', $request);

        $this->assertCount(1, $data);
        $this->assertSame('STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!', $data[0]);
    }

    public function testValidRequestEinsteinTwo(): void
    {
        $request = [
            'author' => 'Albert Einstein',
            'amount' => 2,
        ];

        $data = $this->getValidPostResponse('/api/shouts', $request);

        $this->assertSame('STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!', $data[0]);
        $this->assertSame('A PERSON WHO NEVER MADE A MISTAKE NEVER TRIED ANYTHING NEW!', $data[1]);
    }

    public function testValidRequestJobs(): void
    {
        $request = [
            'author' => 'Steve Jobs',
            'amount' => 2,
        ];

        $data = $this->getValidPostResponse('/api/shouts', $request);

        $this->assertSame('YOUR TIME IS LIMITED, SO DON’T WASTE IT LIVING SOMEONE ELSE’S LIFE!', $data[0]);
        $this->assertSame('THE ONLY WAY TO DO GREAT WORK IS TO LOVE WHAT YOU DO!', $data[1]);
    }

    public function testNotEnoughQuotes(): void
    {
        $request = [
            'author' => 'Albert Einstein',
            'amount' => 3,
        ];

        $data = $this->getInvalidPostResponse('/api/shouts', $request);

        $this->assertSame('Not enough quotes for given author. Maximum quotes: 2', $data['detail']);
    }

    public function testAuthorDoesNotExist(): void
    {
        $request = [
            'author' => 'I do not exist',
            'amount' => 1,
        ];

        $data = $this->getInvalidPostResponse('/api/shouts', $request);

        $this->assertSame('Author was not found.', $data['detail']);
    }

    /**
     * @dataProvider _invalidAmountGraterThanMaximumProvider
     */
    public function testInvalidAmountGraterThanMaximum(int $amount): void
    {
        $request = [
            'author' => 'Albert Einstein',
            'amount' => $amount,
        ];

        $data = $this->getInvalidPostResponse('/api/shouts', $request);

        $this->assertSame('amount: This value should be less than or equal to 10.', $data['detail']);
    }

    /**
     * @return mixed[]
     */
    public function _invalidAmountGraterThanMaximumProvider(): array
    {
        return [[11], [100], [1000]];
    }

    /**
     * @dataProvider _invalidAmountLowerThanLimitProvider
     */
    public function testInvalidAmountLowerThanLimit(int $amount): void
    {
        $request = [
            'author' => 'Albert Einstein',
            'amount' => $amount,
        ];

        $data = $this->getInvalidPostResponse('/api/shouts', $request);

        $this->assertSame('amount: This value should be greater than 0.', $data['detail']);
    }

    /**
     * @return mixed[]
     */
    public function _invalidAmountLowerThanLimitProvider(): array
    {
        return [[0], [-1], [-111]];
    }
}
