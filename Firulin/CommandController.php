<?php

namespace Firulin;
require_once 'Command.php';
use Firulin\Command;

class CommandController extends Command
{    
    protected $path = "app/Controllers";
    protected $nameClass = "Controllers";
    
    public function start()
    {
        switch ($this->line) {
            case 'create':
                print $this->createFile($this->nameFile);
                break;
            default:
                print("salve");
                break;
        }
    }

}
