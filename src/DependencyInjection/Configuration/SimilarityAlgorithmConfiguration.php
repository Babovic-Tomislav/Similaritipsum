<?php

namespace App\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class SimilarityAlgorithmConfiguration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('app');

        $rootNode = $treeBuilder->getRootNode();
        $this->addSimilarityAlgorithmConfigurationSection($rootNode);

        return $treeBuilder;
    }

    private function addSimilarityAlgorithmConfigurationSection(ArrayNodeDefinition $node): void
    {
        $node->children()
             ->arrayNode('similarity_algorithms')
                 ->useAttributeAsKey('identifier')
                 ->arrayPrototype()
                     ->children()
                         ->scalarNode('class')->end()
                         ->scalarNode('name')->end()
                         ->scalarNode('description')->end()
                     ->end()
                 ->end()
                 ->end()
             ->end();
    }
}

