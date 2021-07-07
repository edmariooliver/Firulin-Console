<?php

/**
 *  Command class
 */

 namespace Firulin;

class Command
{
    /**
     * Class path name
     * @var string 
     */
    protected $path = "/app";
    
    /**
     * @var string
     */
    protected $line;

    /**
     * filename received by command
     * @var string 
     */
    protected $nameFIle;
    
    /**
     * Firulin command list
     * @var 
     */
    protected $commands = ["model:create", "controller:create", "project:create"];
    
    /**
     * List of internal folders in the project
     * @var array 
     */
    protected $pathsProject = ["Models", "Routes", "Controllers", "Views"];
    
    /**
     * Project layer name
     * @var string  
     */
    protected $nameClass;

    public function __construct($line)
    {   
        $this->line = $line["action"];
        $this->nameFile = $line["name"];
    }

    /**
     * Apresentando o Firulin no console
     * @return bool
     */
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
        return true;
    }

    /**
     * This function that creates the project
     * @param null
     * @return bool
     */
    public function createProject()
    {
        print $this->messageLoad("Criando app...");
        if(is_dir(__DIR__."/../app/")){
            print $this->messageSuccess("O projeto já está criado!");
            return false;
        }
        mkdir(__DIR__."/../app/");
        if(!is_dir(__DIR__."/../app/")){
            print $this->messageSuccess("Ocorreu um erro ao criar o projeto!");
            return false;
        }
        print $this->messageSuccess("Ok!");
        foreach($this->pathsProject as $path){
            print $this->messageLoad("Criando ".$path."...");
            mkdir(__DIR__."/../app/".$path, 0777, true);
            print $this->messageSuccess("Ok!");
        }
        print "\033[1;33mGerando htaccess\033[0m\n";
        if(is_file(__DIR__."/../.htaccess")){
            print $this->messageError("Ocorreu um erro ao gerar o htaccess");
        }else{
            $htaccess = fopen(__DIR__."/../.htaccess", "x+");
            print $this->messageSuccess("Ok!");
            fclose($htaccess);
        }
        return true;
    }

    /**
     * Send message error in console
     * @param string $msg
     * @return string
     */
    public function messageError($msg)
    {
        $date = "[".date("h:m:s")."] ";
        return "\033[1;31m".$date.$msg."\033[0m\n";
    }

    /**
     * Send message load in console
     * @param string $msg
     * @return string
     */
    public function messageLoad($msg)
    {
        $date = "[".date("h:m:s")."] ";
        return "\033[1;33m".$date.$msg."\033[0m\n";
    }

    /**
     * Send message success in console
     * @param string @msg
     * @return string
     */
    public function messageSuccess($msg)
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

            //Open new file or create new file
            $file = fopen($this->path."/".$name.".php", "x+");

            if(!$file){
                return $this->messageError("Impossível criar o novo arquivo");
            }else{
                //Open model
                $fileModel = __DIR__."/Modelos/modelo.txt";
                $model = fopen($fileModel, "r");
                $content = fread($model, filesize($fileModel));
                $content = str_replace("0", $this->nameClass, $content);
                $content = str_replace("1", $this->nameFile, $content);
                $namespace = 'App\.'.$this->nameClass;
                
                //Set model in new file
                fwrite($file, $content);

                //Close files
                fclose($file);
                fclose($model);

                return $this->messageSuccess("Sucesso!");
            }  
        }else{
            print($this->messageError("Impossível criar o arquivo"));
            print($this->messageSuccess("Segue o comando abaixo:\nCOMANDO: php firulin [comando] [nome-do-arquivo]"));
        }
    }
  
    /**
     * Init process 
     */
    public function start()
    {
        switch ($this->line) {
            case 'create':
                $this->createProject($this->nameFile);
                break;
            default:
                print($this->messageError("Comando não encontrado!"));
                print($this->messageSuccess("Segue os comandos abaixo:"));
                foreach($this->commands as $command){
                    print($command."\n");
                }
                break;
        }
    }
}
