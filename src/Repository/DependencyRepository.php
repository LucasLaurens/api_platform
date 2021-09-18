<?php

namespace App\Repository;

use App\Entity\Dependency;
use Ramsey\Uuid\Uuid;

class DependencyRepository
{
    /**
     * @var string
     */
    public function __construct(private string $rootPath) {}

    public function findAll(): array
    {
        $items = [];
        foreach($this->getDependencies() as $name => $version) {
            $items[] = new Dependency($name, $version);
        } unset($name, $verison);

        return $items;
    }

    /**
     *
     * @param string $uuid
     * @return Dependency[]|null
     */
    public function find(string $uuid): ?Dependency
    {
        foreach($this->findAll() as $dependency) {
            if($uuid === $dependency->getUuid()) {
                return $dependency;
            }
        } unset($dependency);

        return null;
    }

    public function persist(Dependency $dependency)
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        $json['require'][$dependency->getName()] = $dependency->getVersion();
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function remove(Dependency $dependency)
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        unset($json['require'][$dependency->getName()]);
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
    
    private function getDependencies(): array
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);

        return $json['require'];
    }
}
