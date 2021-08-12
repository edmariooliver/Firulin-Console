<?php

/** 
 *  PHP version 8.0
 *  Command class
 */

namespace App\src;

class Command
{
    /**
     * Class path name
     * @var string 
     */
    protected $path = __DIR__."/../../project/";
    
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
     * @var array
     */
    protected $commands = ["model:create", "controller:create", "project:create"];
    
    /**
     * List of internal folders in the project
     * @var array 
     */
    protected $foldersProject = ["Models", "Routes", "Controllers", "Views"];
    
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
        print "\033[1;33mVersão 1.0\nAutor: Edmário Oliveira\033[0m\n";
        print "\n";
        print "\033[1;32mCOMANDOS:\033[0m\n";

        foreach($this->commands as $command){
            print " ".$command."\n";
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
        if(is_dir($this->path)){
            print $this->messageSuccess("O projeto já está criado!");
            return false;
        }
    
        mkdir($this->path);
        
        if(!is_dir($this->path)){
            print $this->messageSuccess("Ocorreu um erro ao criar o projeto!");
            return false;
        }

        foreach($this->foldersProject as $path){
            print $this->messageLoad("Criando ".$path."...");
            mkdir($this->path."/".$path, 0777, true);
            print $this->messageSuccess("Ok!");
        }

        if(is_file($this->path."htaccess")){
            print $this->messageError("Ocorreu um erro ao gerar o htaccess");
        }else{
            $htaccess = fopen($this->path."/.htaccess", "x+");
            fclose($htaccess);
        }

        if(is_file($this->path."index.php")){
            print $this->messageError("Ocorreu um erro ao gerar o htaccess");
        }else{
            $htaccess = fopen($this->path."/index.php", "x+");
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
            $file = fopen($this->path.$this->nameClass."/".$name.".php", "x+");

            if(!$file){
                return $this->messageError("Impossível criar o novo arquivo");
            }else{
                //Open model
                $fileModel = __DIR__."/../assets/modelo.txt";
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
