<?php

namespace PradoDigital\Bundle\DicephraseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('prado_digital_dicephrase');

        $rootNode
            ->children()
                ->scalarNode('dice')
                    ->cannotBeEmpty()
                    ->defaultValue('openssl')
                    ->validate()
                        ->ifNotInArray(array('rand', 'openssl'))
                        ->thenInvalid('Invalid dice type "%s"')
                    ->end()
                ->end()
                ->scalarNode('wordlist')
                    ->cannotBeEmpty()
                    ->defaultValue('%kernel.root_dir%/../src/PradoDigital/Bundle/DicephraseBundle/Resources/diceware/diceware.wordlist.asc')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
