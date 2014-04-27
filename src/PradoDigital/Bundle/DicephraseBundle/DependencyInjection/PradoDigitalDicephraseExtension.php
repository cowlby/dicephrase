<?php

namespace PradoDigital\Bundle\DicephraseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PradoDigitalDicephraseExtension extends Extension
{
    private $diceClasses = array(
        'rand' => 'PradoDigital/Bundle/DicephraseBundle/Diceware/RandDice',
        'openssl' => 'PradoDigital/Bundle/DicephraseBundle/Diceware/OpensslDice',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Set the Dice class.
        $diceType = ucfirst($config['dice']) . 'Dice';
        $diceNamespace = 'PradoDigital\Bundle\DicephraseBundle\Diceware';
        $diceClass = $diceNamespace . '\\' . $diceType;

        $container->setParameter('prado_digital.dicephrase.diceware.dice.class', $diceClass);

        // Set the path to the wordlist.
        $container->setParameter('prado_digital.dicephrase.diceware.wordlist.path', $config['wordlist']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
