<?php

namespace Firulin;

require_once 'Command.php';
use Firulin\Command;

class CommandController extends Command
{    
    protected $path = "app/Controllers";

    /**
     * 
     */
    public function start()
    {
        switch ($this->line) {
            case 'create':
                print $this->createArchive($this->nameArchive);
                break;
            default:
                print("salve");
                break;
        }
    }
    
    /**
     * @param string @name
     * @return string
     */
    public function createArchive($name)
    {
        $archive = fopen($this->path."/".$name.".php", "x+");
        if(!$archive){
            return parent::messageError("Impossível criar o novo arquivo");
        }else{
            fwrite($archive, "<?php \n  namespace App; \n class ".$this->nameArchive."\n { \n }");
            fclose($archive);  
            return parent::messageSucess("Sucesso!");
        }  
    }
}
