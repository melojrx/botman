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
    protected $isAtleta;

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
            $this->askForBodybuilder();
        });
    }

        public function askForBodybuilder()
    {
        $question = Question::create('Me diz, você já é Fisiculturista?')
            ->fallback('Vem ser com a gente!')
            ->callbackId('Legal!')
            ->addButtons([
                Button::create('Sim')->value(true),
                Button::create('Não')->value(false),
            ]);
    
        $this->ask($question, function ($answer) {
            $this->isAtleta = $answer->getValue();
            $this->say('RESPOSTA, '. $this->isAtleta); // apenas para printar em tela e vermos o valor
        });
    }

    public function run()
    {
        $this->askFirstname();
    }
}
