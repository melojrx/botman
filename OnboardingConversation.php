<?php

use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OnboardingConversation extends Conversation
{

    protected $firstname;
    protected $email;
    protected $phone;
    protected $location;
    protected $city;

    public function askFirstname()
    {
        $this->ask('Olá. Por favor, informe seu nome?', function($answer) {
            $firstName = $answer->getText();
            $this->say('Bem-vindo, '.$firstName);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Nos informe seu email?', function($answer) {
            // Save result
            $this->email = $answer->getText();
            $this->say('Obrigado!, '.$this->firstname); 
            $this->askPhone();
        });
    }
    public function askPhone()
    {
        $this->ask('Qual seu Telefone com DDD?', function($answer) {
            // Save result 
            $this->phone = $answer->getText();
            $this->say('Legal!'.$this->firstname);
            $this->askMood();
        });
    }
    public function askMood() 
    {
        $this->ask('Qual seu endereço?', function($answer) {
            $this->location = $answer->getText();
            $this->say('Massa! '.$this->firstname);
            $this->askForDatabase();
        });
    }
    public function askForDatabase()
    {
        $question = Question::create('Me diz, você já é Fisiculturista?')
            ->fallback('Não.')
            ->callbackId('Sim!')
            ->addButtons([
                Button::create('Sim')->value('yes'),
                Button::create('Não!')->value('no'),
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
