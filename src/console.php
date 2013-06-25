<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

$console = new Application('Dicephrase', '0.1');

$app->boot();

$console
    ->register('dicephrase:generate')
    ->setName('dicephrase:generate')
    ->setDescription('Generate password')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $output->writeln('<info>Update complete.</info>');
    })
;

return $console;
