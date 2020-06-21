<?php

declare(strict_types=1);

namespace App\Tests\Api\Base;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class BaseTestCase extends ApiTestCase
{
    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    final public function getValidPostResponse(string $url, array $data): array
    {
        $response = $this->makeRequestToApi($url, $data);

        $statusCode = $response->getStatusCode();

        $this->assertSame(200, $statusCode);

        $content = $response->getContent();

        return json_decode($content, true);
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    final public function getInvalidPostResponse(string $url, array $data): array
    {
        $response = $this->makeRequestToApi($url, $data);

        $statusCode = $response->getStatusCode();

        $this->assertSame(400, $statusCode);

        $content = $response->getContent(false);

        return json_decode($content, true);
    }

    /**
     * @param mixed[] $data
     */
    private function makeRequestToApi(string $url, array $data): ResponseInterface
    {
        $client = HttpClient::create();

        return $client->request('POST', sprintf('http://localhost/Ipresence/public%s', $url), [
            'json' => $data,
        ]);
    }
}
