<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\ApiResource\Shout;
use App\Exception\AuthorNotFoundException;
use App\Exception\InvalidResourceException;
use App\Exception\NotEnoughQuotesException;
use App\Operation\ShoutOperation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShoutDataPersister implements DataPersisterInterface
{
    /**
     * @var ShoutOperation
     */
    private $shoutOperation;

    public function __construct(ShoutOperation $shoutOperation)
    {
        $this->shoutOperation = $shoutOperation;
    }

    /**
     * @param mixed|object $data
     */
    public function supports($data): bool
    {
        return $data instanceof Shout;
    }

    /**
     * @param Shout $data
     */
    public function persist($data): Response
    {
        try {
            return $this->shoutOperation->shout($data);
        } catch (AuthorNotFoundException | InvalidResourceException | NotEnoughQuotesException $e) {
            $response = [
                'detail' => $e->getMessage(),
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Shout $data
     *
     * @throws NotFoundHttpException
     */
    public function remove($data): void
    {
        throw new NotFoundHttpException('Shout resource cannot be deleted');
    }
}
