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
    protected $idModalidade;
    protected $txtModalidade;
    protected $isAtleta;
    protected $isMusculacao;
    protected $isMartial;

    public function askFirstname()
    {
        $this->ask('Olá. Por favor, informe seu nome?', function($answer) {
            $this->firstname = $answer->getText();
            $this->say('Bem-vindo, '.$this->firstname);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Nos informe seu email?', function($answer) {
            $this->email = $answer->getText();
            $valida = $this->ValidaEmail();
            if($valida){
                $this->say('Obrigado!, '.$this->firstname); 
                $this->askPhone();
            } else {
                $this->askEmailAgain();
            }


        });
    }

    public function askEmailAgain()
    {
        $this->ask('E-mail inválido. Por favor, nos informe um e-mail válido.', function($answer) {
            $this->email = $answer->getText();
            $valida = $this->ValidaEmail();
            if($valida){
                $this->say('Obrigado!, '.$this->firstname); 
                $this->askPhone();
            } else {
                $this->askEmailAgain();
            }


        });
    }

    public function askPhone()
    {
        $this->ask('Qual seu Telefone com DDD?', function($answer) {
            // Save result 
            $this->phone = $answer->getText();
            $this->say('Legal,'.$this->firstname);
            $this->askMood();
        });
    }
    public function askMood() 
    {
        $this->ask('Qual seu endereço?', function($answer) {
            $this->location = $answer->getText();
            $this->say('Massa, '.$this->firstname);
            $this->askForBodybuilder();
        });
    }

    public function askForBodybuilder()
    {
        $question = Question::create('Me diz, você já é Fisiculturista?')
            ->addButtons([
                Button::create('Sim')->value(true),
                Button::create('Não')->value(false),
            ]);
    
        $this->ask($question, function ($answer) {
            $this->isAtleta = $answer->getValue();
            $this->askForMusculacao();
        });
    }

    public function askForMusculacao()
    {
        $question = Question::create('Você pratica musculação?')
            ->addButtons([
                Button::create('Sim')->value(true),
                Button::create('Não')->value(false),
            ]);
    
        $this->ask($question, function ($answer) {
            $this->isMusculacao = $answer->getValue();
            $this->askForMartialArts();
        });
    }

    public function askForMartialArts()
    {
        $question = Question::create('Me diz outra coisa, você pratica artes marciais?')
            ->addButtons([
                Button::create('Sim')->value('Sim'),
                Button::create('Não')->value('Nao'),
            ]);
    
        $this->ask($question, function ($answer) {
            $this->isMartial =($answer->getValue() == 'Sim') ? true : false;
            if($this->isMartial){
                $this->askForModalidade();
            }else{
                $this->askForSaveIntoDatabase();
            }

        });
    }

    public function askForModalidade()
    {
        $this->ask('Excelente! Digite o número da modalidade que você pratica? <br/>
                    1 - MMA <br/>
                    2 - Jiu-Jitsu <br/>
                    3 - Boxe <br/>
                    4 - Muay Thai <br/>
                    5 - KaratÊ <br/>
                    6 - Outros', function($answer) {
            $this->idModalidade = (int) $answer->getText();
            if($this->idModalidade != 1 && $this->idModalidade != 2 && $this->idModalidade != 3 &&
                    $this->idModalidade != 4 && $this->idModalidade != 5 && $this->idModalidade != 6) {
                $this->askForModalidadeAgain();
            } else if($this->idModalidade == 6) {
                $this->askForTextoModalidade();
            } else {
                $this->txtModalidade = "";
                $this->askForSaveIntoDatabase();
            }

        });
    }

    public function askForModalidadeAgain()
    {
        $this->ask("Não Entendi! Digite o número da modalidade que você pratica? <br/>
                    1 - MMA <br/>
                    2 - Jiu-Jitsu <br/>
                    3 - Boxe <br/>
                    4 - Muay Thai <br/>
                    5 - KaratÊ <br/>
                    6 - Outros <br/>", function($answer) {
            $this->idModalidade = (int)$answer->getText();
            if($this->idModalidade != 1 && $this->idModalidade != 2 && $this->idModalidade != 3 &&
                $this->idModalidade != 4 && $this->idModalidade != 5 && $this->idModalidade != 6) {
                    $this->askForModalidadeAgain();
            } else if($this->idModalidade == 6) {
                $this->askForTextoModalidade();
            } else {
                $this->txtModalidade = "";
                $this->askForSaveIntoDatabase();
            }

        });
    }

    public function askForTextoModalidade()
    {
        $this->ask("Que diferente! Qual modalidade você Pratica?", function($answer) {
        $this->txtModalidade = $answer->getText();
        $this->say('Massa, '.$this->firstname);
        $this->askForSaveIntoDatabase();
        });
    }

    public function askForSaveIntoDatabase()
    {
        $question = Question::create('Clique em Sim para confirmar seu cadastro.')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Sim')->value('Sim'),
                Button::create('Não')->value('Nao'),
            ]);
    
        $this->ask($question, function ($answer) {
            $selected =($answer->getValue() == 'Sim') ? true : false;
            // Detect if button was clicked:
            if($selected) {
//                $retorno = $this->save();
//                $this->say('retorno, '.$retorno);
                $this->save();
                $this->say('Parabéns, '.$this->firstname.'. Cadastro Confirmado!');
            } else {
                $this->askForSaveIntoDatabase();
            }
        });
    }

    // Validador de E-mail 
    public function ValidaEmail() 
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function save() 
    {
        $sql = "INSERT INTO tb_cliente_cli (txt_nome_cli, txt_email_cli, txt_endereco_cli, txt_fone_cli, 
                id_modalidade_cli, txt_modalidade_cli, flg_fisicuturista_cli, flg_musculacao_cli , flg_marcial_cli) 
        VALUES ('$this->firstname','$this->email','$this->location','$this->phone','$this->idModalidade', 
                '$this->txtModalidade','$this->isAtleta','$this->isMusculacao','$this->isMartial')";
        $conn = new conexao;
        $conn->db()->query($sql);
//        return $sql;
    }

    public function run()
    {
        $this->askFirstname();
    }
}