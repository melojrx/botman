<?php

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

require_once('conn.php');

class OnboardingConversation extends Conversation
{

    protected $firstname;
    protected $email;
    protected $phone;
    protected $location;
    protected $city;
    protected $isAtleta;
    protected $isMartial;

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
            $this->askForMartialArts();
        });
    }

    public function askForMartialArts()
    {
        $question = Question::create('Me diz outra coisa, você pratica artes marciais?')
            ->fallback('Vem praticar com a gente!')
            ->callbackId('Legal!')
            ->addButtons([
                Button::create('Sim')->value(true),
                Button::create('Não')->value(false),
            ]);
    
        $this->ask($question, function ($answer) {
            $this->isMartial = $answer->getValue();
            $this->askForSaveIntoDatabase();
        });
    }

    public function askForSaveIntoDatabase()
    {
        $question = Question::create('Clique em Sim para Salvar informações no Banco de Dados.')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Sim')->value(true),
                Button::create('Não')->value(false),
            ]);
    
        $this->ask($question, function ($answer) {
            // Detect if button was clicked:
            if($answer->getValue()){
                $this->save();
                $this->say('Cadastro Confirmado! '.$this->firstname);
            } else{
                $this->askForSaveIntoDatabase();
            }
        });
    }

    public function save() 
    {
        $sql = "INSERT INTO tb_cliente_cli (txt_nome_cli, txt_email_cli,	txt_endereco_cli, txt_fone_cli,	flg_fisicuturista_cli, flg_marcial_cli)
        VALUES ('$this->firstname','$this->email','$this->location','$this->phone','$this->isAtleta','$this->isMartial')";
        $conn = new conexao;
        $conn->db()->query($sql);
    }

    public function run()
    {
        $this->askFirstname();
    }
}
