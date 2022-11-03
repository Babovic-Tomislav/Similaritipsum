<?php

namespace App\DependencyInjection;

use App\DependencyInjection\Configuration\SimilarityAlgorithmConfiguration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new SimilarityAlgorithmConfiguration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerSimilarityAlgorithms($container, $config['similarity_algorithms'] ?? []);
    }

    private function registerSimilarityAlgorithms(ContainerBuilder $container, array $config)
    {
        $algorithms = [];
        $params = [];

        foreach ($config as $algorithm => $algorithmConfig) {
            if ($algorithmConfig['class']) {
                $algorithms[$algorithmConfig['name'].'.similarity_algorithm'] = new Reference($algorithmConfig['class']);
                $algorithmNames []= $algorithmConfig['name'];
                $algorithmDescriptions []= $algorithmConfig['description'];
            }
        }

        $container->setParameter('similarity_algorithms_name', $algorithmNames);
        $container->setParameter('similarity_algorithms_description', $algorithmDescriptions);

        $serviceLocator = new Definition(ServiceLocator::class, [$algorithms]);
        $serviceLocator->setPublic(false);
        $serviceLocator->addTag('container.service_locator');

        $container->setDefinition('similarity_algorithms.algorithms_handlers', $serviceLocator);
    }
}

