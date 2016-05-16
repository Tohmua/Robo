<?php
use Robo\Config;
use Robo\Runner;
use Robo\Container\RoboContainer;
use Symfony\Component\Console\Input\StringInput;

// This is global bootstrap for autoloading
$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug' => true,
    'includePaths' => [
        __DIR__.'/../src',
        __DIR__.'/../vendor/symfony/process',
        __DIR__.'/../vendor/symfony/console',
    ]
]);


$container = new RoboContainer();
$input = new StringInput('');
Runner::configureContainer($container, $input);
Config::setContainer($container);