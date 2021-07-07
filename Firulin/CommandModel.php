<?php

namespace Firulin;
require_once 'Command.php';
use Firulin\Command;

class CommandModel extends Command
{    
    protected $path = "app/Models";
    protected $nameClass= "Models";
    
    public function start()
    {
        switch ($this->line) {
            case 'create':
                print $this->createFile($this->nameFile);
                break;
        }
    }
}
