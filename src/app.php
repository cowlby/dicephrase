<?php

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;

$app = new Application();

// Providers
$app->register(new UrlGeneratorServiceProvider());

// Services
$app['diceware.dice'] = $app->share(function($container) {
    return new $container['diceware.dice.class']();
});

$app['diceware.roller'] = $app->share(function($container) {
    return new $container['diceware.roller.class']($container['diceware.dice']);
});

$app['diceware.wordlist'] = $app->share(function($container) {
    return new $container['diceware.wordlist.class']($container['diceware.wordlist.path']);
});

$app['diceware'] = $app->share(function($container) {
    return new $container['diceware.class']($container['diceware.wordlist'], $container['diceware.roller']);
});

return $app;
