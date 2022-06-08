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

$botman->hears(['.*Oi.*', '.*Olá.*', '.*Bom dia.*', '.*Boa Tarde.*', '.*Boa Noite.*', '.*Ola.*'], function($bot) {
    
    $bot->startConversation(new OnboardingConversation);
    
});

$botman->fallback(function($bot) {
    $bot->reply('Desculpe! Não entendi. Que tal começarmos com um "Oi", "Olá", "Bom dia", "Boa tarde" ou "Boa noite"? Essas palavras eu entendo. :)');
});

$botman->listen();