<?php

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;
use Cowlby\Dicephrase\Dice;
use Cowlby\Dicephrase\DiceRoller;
use Cowlby\Dicephrase\WordList;
use Cowlby\Dicephrase\PassphraseMaker;

$app = new Application();

// Providers
$app->register(new UrlGeneratorServiceProvider());

// Services
$app['diceware.dice'] = $app->share(function($container) {
    return new Dice();
});

$app['diceware.roller'] = $app->share(function($container) {
    return new DiceRoller($container['diceware.dice']);
});

$app['diceware.wordlist'] = $app->share(function($container) {
    return new WordList($container['diceware.wordlist.path']);
});

$app['diceware'] = $app->share(function($container) {
    return new PassphraseMaker($container['diceware.wordlist'], $container['diceware.roller']);
});

return $app;
