<?php

use Symfony\Component\Yaml\Yaml;

$app['name'] = stripcslashes(getenv('APP_NAME'));

// Debug
$app['debug'] = false;

// Locale
$app['locale'] = 'en';
$app['locale_fallback'] = 'en';
$app['session.default_locale'] = $app['locale'];
$app['translator.domains'] = array();

// Cache
$app['cache.path'] = __DIR__.'/../cache';

// Http cache
$app['http_cache.cache_dir'] = $app['cache.path'].'/http';
$app['http_cache.options'] = array(
    'debug' => $app['debug'],
    'stale_if_error' => 0
);

// Session
$app['session.storage.options'] = array('name' => 'DICEPHRASESESSID');

// Twig
$app['twig.path'] = __DIR__.'/../views';

// Dicephrase
$app['diceware.dictionary.beale'] = __DIR__ . '/../diceware/beale.wordlist.asc';
$app['diceware.dictionary.standard'] = __DIR__ . '/../diceware/diceware.wordlist.asc';
