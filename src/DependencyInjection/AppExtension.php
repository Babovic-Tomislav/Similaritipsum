<?php

namespace App\DependencyInjection;

use App\DependencyInjection\Configuration\SimilarityAlgorithmConfiguration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new SimilarityAlgorithmConfiguration();

        $this->processConfiguration($configuration, $configs);
    }
}

