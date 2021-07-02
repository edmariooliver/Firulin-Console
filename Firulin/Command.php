<?php

namespace Firulin;

class Command
{
    protected $path = "/app";
    protected $line;
    protected $nameArchive;

    public function __construct($line)
    {   
        $this->line = $line["action"];
        $this->nameArchive = $line["name"];
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
     * @param string @path
     * @return
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $msg
     * @return string
     */
    public function messageError($msg)
    {
        return "\033[1;31m".$msg."\033[0m\n";
    }

    /**
     * @param string @msg
     * @return string
     */
    public function messageSucess($msg)
    {
        return "\033[1;32m".$msg."\033[0m\n";
    }

    /**
     * @param string @name
     * @return string
     */
    public function createArchive($name)
    {
        //
    }
    
    /**
     * 
     */
    protected function excpetion()
    {
        //
    }
  
    /**
     * 
     */
    public function start()
    {
        //
    }
}
