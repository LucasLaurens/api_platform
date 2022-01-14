<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Api\Resource\LogMessageResource;
use Psr\Log\LoggerInterface;

final class LogMessageDataPersister implements DataPersisterInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function supports($data): bool
    {
        return $data instanceof LogMessageResource;
    }

    /**
     * @param LogMessageResource $data
     * @return object|void
     */
    public function persist($data)
    {
        $message = sprintf('---> %s <---', $data->getMessage());
        $this->logger->debug($message);
        return $data;
    }

    public function remove($data)
    {
    }
}
