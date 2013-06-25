<?php

use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app->register(new HttpCacheServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => 'en'
));

$app->register(new TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true
    ),
    'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path' => array(__DIR__ . '/../resources/views')
));

$app['nf'] = $app->share(function($container) {
    return new NumberFormatter('en_US', NumberFormatter::CURRENCY);
});

$app['diceware'] = $app->share(function($container) {

    $dictionary = null;

    $cachedFile = $container['cache.path'] . '/wordlist.txt';
    if (file_exists($cachedFile)) {
        $dictionary = unserialize(file_get_contents($cachedFile));
    }

    if (empty($dictionary)) {

        $fh = fopen($container['diceware.dictionary.beale'], 'r');

        if ($fh === false) {
            throw new \Exception('Could not open dictionary.');
        }

        $dictionary = array();
        while (($buffer = fgets($fh)) !== false) {
            if (preg_match('/^([1-6]{5})\s+(.*)/', $buffer, $matches)) {
                $dictionary[intval($matches[1])] = $matches[2];
            }
        }

        if (!feof($fh)) {
            throw new \Exception('Unexpected fgets() fail');
        }

        file_put_contents($cachedFile, serialize($dictionary));
        fclose($fh);
    }

    return $dictionary;
});

return $app;
