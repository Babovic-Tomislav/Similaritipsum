<?php

namespace App\Service;

use App\Exception\AlgorithmNotFound;
use App\SimilarityAlgorithms\SimilarityAlgorithm;
use Symfony\Component\DependencyInjection\ServiceLocator;

class AlgorithmManager
{
    public function __construct(private ServiceLocator $serviceLocator)
    {
    }

    /**
     * @param string $identifier
     * @return SimilarityAlgorithm
     * @throws AlgorithmNotFound
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getAlgorithm(string $identifier): SimilarityAlgorithm
    {
        $serviceName = $identifier . '.similarity_algorithm';

        if (!$this->serviceLocator->has($serviceName)) {
            throw new AlgorithmNotFound();
        }

        return $this->serviceLocator->get($serviceName);
    }
}

