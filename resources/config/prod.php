<?php

$app['name'] = stripcslashes(getenv('APP_NAME')) ?: 'dicephrase';

// Debug
$app['debug'] = false;

// Cache
$app['cache.path'] = __DIR__.'/../../cache';

// Dicephrase
$app['diceware.wordlist.path'] = __DIR__ . '/../diceware/diceware.wordlist.asc';
$app['diceware.dice.class']     = stripcslashes(getenv('DICEPHRASE__DICE__CLASS')) ?: 'Cowlby\Dicephrase\RandDice';
$app['diceware.roller.class']   = 'Cowlby\Dicephrase\DiceRoller';
$app['diceware.wordlist.class'] = stripcslashes(getenv('DICEPHRASE__WORDLIST__CLASS')) ?: 'Cowlby\Dicephrase\FileWordList';
$app['diceware.class']          = 'Cowlby\Dicephrase\PassphraseMaker';
