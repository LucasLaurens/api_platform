<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Feedback;

class FeedbackDataProvider
implements 
    ContextAwareCollectionDataProviderInterface, # get context
    RestrictedDataProviderInterface, # manage the support to use it
    ItemDataProviderInterface
{
    private array $test = [];

    public function __construct(private string $rootPath) {}

    /**
     *
     * @param string $resourceClass get the namespace
     * @param string|null $operationName get the HTTP method
     * @param array $context get array with different information
     * @return void
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        // dd($resourceClass, $operationName, $context);
        return $this->test;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // dd($resourceClass, $operationName, $context);
        return $this->test[0];
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Feedback::class;
    }
}
