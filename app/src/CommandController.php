<?php

namespace App\src;

require_once "vendor/autoload.php";
use App\src;

class CommandController extends Command
{    
    protected $path = __DIR__."/../../project/";
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
