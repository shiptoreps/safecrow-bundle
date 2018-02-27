<?php
namespace SafeCrowBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package SafeCrowBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('safecrow');

        $rootNode
            ->children()
                ->arrayNode('clients')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('key')
                                ->isRequired()
                            ->end()
                            ->scalarNode('secret')
                                ->isRequired()
                            ->end()
                            ->booleanNode('dev')
                                ->defaultTrue()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
