<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;

require_once('OnboardingConversation.php');

$config = [];

DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

$adapter = new FilesystemAdapter();

$botman = BotManFactory::create($config, new SymfonyCache($adapter));

$botman->hears('Oi', function($bot) {
    
    $bot->startConversation(new OnboardingConversation);
    
});

//$botman->fallback(function($bot) {
//    $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
//});
//

$botman->listen();