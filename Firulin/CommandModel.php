<?php

namespace Firulin;

require_once 'Command.php';
use Firulin\Command;

class CommandModel extends Command
{    
    protected $path = "app/Models";
    
    public function start()
    {
        switch ($this->line) {
            case 'create':
                print $this->createArchive($this->nameArchive);
                break;
        }
    }
    
    /**
     * @param string @name
     * @return string
     */
    public function createArchive($name)
    {
        print mkdir("/path/to/my/dir", 0700, true);
        $archive = fopen($this->path."/".$name.".php", "x+");
        if(!$archive){
            
            return parent::messageError("Models: Impossível criar o novo arquivo");
        }else{
            fwrite($archive, "<?php \n namespace App; \n class ".$this->nameArchive."\n { \n }");
            fclose($archive);  
            return parent::messageSucess("Sucesso!");
        }  
    }
}