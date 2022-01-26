<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryDataPersister implements
ContextAwareDataPersisterInterface
{
    public const DEFAULT_STRING = 'string';
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Category;
    }

    public function persist($data, array $context = [])
    {
        if (self::DEFAULT_STRING === $data->getName()) {
            $data->setName("Magic persist: " . $data->getName());
        }

        $this->em->persist($data);
        $this->em->flush();

        return  [
            "success" => $data
        ];
    }

    public function remove($data, array $context = [])
    {
        dd($data, $context);
    }
}
