<?php

namespace Integration;

use App\Service\AlgorithmManager;
use App\SimilarityAlgorithms\SimilarityAlgorithm;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlgorithmConfigurationTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testRegisteredAlgorithms()
    {
        $container = static::$kernel->getContainer();
        $algorithmManager = $container->get(AlgorithmManager::class);
        $algorithms = $container->getParameter('similarity_algorithms_name');

        foreach ($algorithms as $algorithm) {
            $algorithmClass = $algorithmManager->getAlgorithm($algorithm);
            $this->assertInstanceOf(SimilarityAlgorithm::class, $algorithmClass);
        }
    }
}

