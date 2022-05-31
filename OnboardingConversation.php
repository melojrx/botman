<?php

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OnboardingConversation extends Conversation
{

    protected $firstname;
    protected $email;

    public function askFirstname()
    {
        $this->ask('Olá. Por favor, informe seu nome?', function($answer) {
            $firstName = $answer->getText();
            $this->say('Bem-vindo '.$firstName);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Nos informe seu email?', function($answer) {
            // Save result
            $this->email = $answer->getText();

            $this->say('Obrigado, '.$this->firstname);
            $this->askForDatabase();
        });
    }

    public function askForDatabase()
    {
        $question = Question::create('Do you need a database?')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Of course')->value('yes'),
                Button::create('Hell no!')->value('no'),
            ]);
    
        $this->ask($question, function ($answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
            }
        });
    }

    public function run()
    {
        $this->askFirstname();
    }
}
