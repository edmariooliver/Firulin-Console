<?php

namespace Firulin;

class Command
{
    protected $path = "/app";
    protected $line;
    protected $nameFIle;
    protected $commands = ["model:create", "controller:create", "project:create"];

    public function __construct($line)
    {   
        $this->line = $line["action"];
        $this->nameFile = $line["name"];
    }

    public function presents()
    {
        print "
             _______  ___  ______  ___    ___   ___        ___  __    ___
            /  ____/ /  / /  ___/ /  /   /  /  /  /       /  / /  \  /  /
           /  /___  /  / /  /    /  /   /  /  /  /       /  / /    \/  / 
          /  ____/ /  / /  /    /  /   /  /  /  /       /  / /  /\    / 
         /  /     /  / /  /    /  /___/  /  /  /_____  /  / /  /  \__/
        /__/     /__/ /__/    /_________/  /________/ /__/ /__/
        \n" ;
        print "\033[1;33mVersão 1.0\nAutor: Edmário Oliveira\033[0m\n";
        print "\n";
        print "\033[1;32mCOMANDOS:\033[0m\n";

        foreach($this->commands as $command){
            print "   ".$command."\n";
        }
    }

    /**
     * @param null
     * @return bool
     */
    public function createProject()
    {
        if(!is_dir(__DIR__."/../app/")){
            mkdir(__DIR__."/../app/Controllers", 0777, true);
            mkdir(__DIR__."/../app/Models", 0777, true);
            mkdir(__DIR__."/../app/Routes", 0777, true);
            mkdir(__DIR__."/../app/Views", 0777, true);
            print $this->messageSucess("Projeto criado com sucesso!");
            return true;
        }else{
            print $this->messageError("AVISO: diretório ocupado");
            return false;
        }
    }

    /**
     * @param string $msg
     * @return string
     */
    public function messageError($msg)
    {
        $date = "[".date("h:m:s")."] ";
        return "\033[1;31m".$date.$msg."\033[0m\n";
    }

    /**
     * @param string @msg
     * @return string
     */
    public function messageSucess($msg)
    {
        $date = "[".date("h:m:s")."] ";
        return "\033[1;32m".$date.$msg."\033[0m\n";
    }

    /**
     * @param string @name
     * @return string
     */
    public function createFile($name)
    {
        if(strlen($name) > 0){
            $file = fopen($this->path."/".$name.".php", "x+");
            if(!$file){
                return $this->messageError("Impossível criar o novo arquivo");
            }else{
                fclose($file);
                return $this->messageSucess("Sucesso!");
            }  
        }else{
            print($this->messageError("Impossível criar o arquivo"));
            print($this->messageSucess("Segue o comando abaixo:\nCOMANDO: php firulin [comando] [nome-do-arquivo]"));
        }
    }
  
    /**
     * 
     */
    public function start()
    {
        switch ($this->line) {

            case 'create':
                print $this->createProject($this->nameFile);
                break;
            default:
                print($this->messageError("Comando não encontrado!"));
                print($this->messageSucess("Segue os comandos abaixo:"));
                foreach($this->commands as $command){
                    print($command."\n");
                }
                break;
        }
    }
}
